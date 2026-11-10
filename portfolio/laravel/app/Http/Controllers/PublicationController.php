<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    private const MAX_ITEMS = 4;

    public function index(): JsonResponse
    {
        $items = Publication::query()
            ->orderByDesc('id')
            ->limit(self::MAX_ITEMS)
            ->get()
            ->values()
            ->map(fn (Publication $pub, int $index) => $this->present($pub, $index));

        return response()->json(['data' => $items])
            ->header('Cache-Control', 'no-store');
    }

    public function store(Request $request, string $token, string $target): JsonResponse
    {
        $expected = (string) config('services.publication_import.token');
        if ($expected === '' || ! hash_equals($expected, $token)) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $validator = Validator::make(['url' => $target], [
            'url' => ['required', 'url', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid URL.', 'errors' => $validator->errors()], 422);
        }

        $url = $target;
        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        if (! in_array($scheme, ['http', 'https'], true) || ! $this->isPublicHost($parts['host'] ?? '')) {
            return response()->json(['message' => 'URL host is not allowed.'], 422);
        }

        try {
            $page = Http::timeout(10)->withHeaders(['User-Agent' => 'ArioDevsBot/1.0'])
                ->accept('text/html')
                ->get($url);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Could not fetch the link.'], 502);
        }

        if (! $page->successful()) {
            return response()->json(['message' => 'Could not fetch the link.'], 502);
        }

        $meta = $this->extractMeta($page->body(), $parts['host']);

        $hash = hash('sha256', $url);
        $pub = DB::transaction(function () use ($url, $hash, $meta) {
            $existing = Publication::where('url_hash', $hash)->first();
            if ($existing) {
                $existing->delete();
            }

            $pub = Publication::create(array_merge($meta, [
                'url' => $url,
                'url_hash' => $hash,
            ]));

            $staleIds = Publication::query()->orderByDesc('id')->pluck('id')->slice(self::MAX_ITEMS)->values();
            if ($staleIds->isNotEmpty()) {
                Publication::whereIn('id', $staleIds)->delete();
            }

            return $pub;
        });

        return response()->json(['data' => $this->present($pub, 0)], 201);
    }

    private function present(Publication $pub, int $index): array
    {
        return [
            'icon' => $pub->icon,
            'title' => $pub->title,
            'venue' => $pub->venue,
            'category' => $pub->category,
            'desc' => $pub->description,
            'url' => $pub->url,
            'delay' => $index === 0 ? '' : 'reveal-delay-' . ($index % 3),
        ];
    }

    public function import(Request $request): JsonResponse
    {
        $expected = (string) config('services.publication_import.token');
        $provided = (string) $request->bearerToken();
        if ($expected === '' || $provided === '' || ! hash_equals($expected, $provided)) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
            'title' => ['nullable', 'string', 'max:500'],
            'venue' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'url', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        $parts = parse_url($validated['url']);
        if (! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
            || ! $this->isPublicHost($parts['host'] ?? '')) {
            return response()->json(['message' => 'URL host is not allowed.'], 422);
        }

        $meta = array_filter([
            'title' => $validated['title'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
        ], static fn ($value) => $value !== null && $value !== '');

        if (count($meta) < 4) {
            try {
                $page = Http::timeout(10)->maxRedirects(3)->withHeaders(['User-Agent' => 'ArioDevsBot/1.0'])
                    ->accept('text/html')->get($validated['url']);
                if ($page->successful()) {
                    $meta = array_merge($this->extractMeta($page->body(), $parts['host']), $meta);
                }
            } catch (\Throwable $e) {
                if (empty($meta['title'])) {
                    return response()->json(['message' => 'Could not fetch the link.'], 502);
                }
            }
        }

        $hash = hash('sha256', $validated['url']);
        $pub = DB::transaction(function () use ($validated, $hash, $meta) {
            Publication::where('url_hash', $hash)->delete();
            $pub = Publication::create(array_merge([
                'url' => $validated['url'],
                'url_hash' => $hash,
                'icon' => 'fas fa-newspaper',
                'venue' => '',
                'category' => '',
                'description' => null,
            ], $meta));

            $staleIds = Publication::query()->orderByDesc('id')->pluck('id')->slice(self::MAX_ITEMS)->values();
            if ($staleIds->isNotEmpty()) {
                Publication::whereIn('id', $staleIds)->delete();
            }

            return $pub;
        });

        return response()->json(['data' => $this->present($pub, 0)], 201);
    }

    private function extractMeta(string $html, string $host): array
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $meta = function (string $name) use ($xpath) {
            $node = $xpath->query("//meta[@property='{$name}' or @name='{$name}']/@content")->item(0);

            return $node ? trim($node->nodeValue) : null;
        };
        $titleNode = $xpath->query('//title')->item(0);

        $title = $meta('og:title') ?: $meta('twitter:title') ?: ($titleNode ? trim($titleNode->textContent) : '');
        $description = $meta('og:description') ?: $meta('description') ?: $meta('twitter:description');
        $siteName = $meta('og:site_name') ?: preg_replace('/^www\./', '', $host);

        return [
            'icon' => 'fas fa-newspaper',
            'title' => Str::limit($title ?: $host, 500, ''),
            'venue' => Str::limit((string) $siteName, 255, ''),
            'category' => 'وب',
            'description' => $description ? Str::limit($description, 1000) : null,
        ];
    }

    private function isPublicHost(string $host): bool
    {
        if ($host === '' || strtolower($host) === 'localhost') {
            return false;
        }
        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : (gethostbynamel($host) ?: []);
        if (empty($ips)) {
            return false;
        }
        foreach ($ips as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return false;
            }
        }

        return true;
    }
}
