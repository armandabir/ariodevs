<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PublicationTranslation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    private const MAX_ITEMS = 4;

    public function index(Request $request): JsonResponse
    {
        $locale = $request->query('locale', 'fa');
        if (! in_array($locale, ['fa', 'en'], true)) {
            return response()->json(['message' => 'Invalid locale.'], 422);
        }

        $items = Publication::query()
            ->where('is_published', true)
            ->with(['translations' => fn ($query) => $query
                ->where('locale', $locale)
                ->where('status', 'approved')])
            ->orderByDesc('id')
            ->get()
            ->filter(fn (Publication $pub) => $pub->translations->isNotEmpty())
            ->take(self::MAX_ITEMS)
            ->values()
            ->map(fn (Publication $pub, int $index) => $this->present($pub, $index, $pub->translations->first()));


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

        $locale = $request->query('locale', 'fa');
        if (! in_array($locale, ['fa', 'en'], true)) {
            return response()->json(['message' => 'Invalid locale.'], 422);
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
        $pub = DB::transaction(function () use ($url, $hash, $meta, $locale) {
            $pub = Publication::where('url_hash', $hash)->first();
            if (! $pub) {
                $pub = Publication::create(array_merge($meta, [
                    'url' => $url,
                    'url_hash' => $hash,
                ]));
            }

            $pub->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $meta['title'] ?? '',
                    'venue' => $meta['venue'] ?? '',
                    'category' => $meta['category'] ?? '',
                    'description' => $meta['description'] ?? null,
                    'status' => 'approved',
                ]
            );

            $staleIds = Publication::query()->orderByDesc('id')->pluck('id')->slice(self::MAX_ITEMS)->values();
            if ($staleIds->isNotEmpty()) {
                Publication::whereIn('id', $staleIds)->delete();
            }

            return $pub;
        });

        $pub->load(['translations' => fn ($query) => $query
            ->where('locale', $locale)
            ->where('status', 'approved')]);

        return response()->json(['data' => $this->present($pub, 0, $pub->translations->first())], 201);
    }

    private function present(Publication $pub, int $index, PublicationTranslation $translation): array
    {
        return [
            'icon' => $pub->icon,
            'title' => $translation->title,
            'venue' => $translation->venue,
            'category' => $translation->category,
            'desc' => $translation->description,
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
            'locale' => ['nullable', 'in:fa,en'],
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
        $locale = $validated['locale'] ?? 'fa';
        $pub = DB::transaction(function () use ($validated, $hash, $meta, $locale) {
            $pub = Publication::where('url_hash', $hash)->first();
            if (! $pub) {
                $pub = Publication::create(array_merge([
                'url' => $validated['url'],
                'url_hash' => $hash,
                'icon' => 'fas fa-newspaper',
                'venue' => '',
                'category' => '',
                'description' => null,
            ], $meta));
            }

            $pub->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $meta['title'] ?? '',
                    'venue' => $meta['venue'] ?? '',
                    'category' => $meta['category'] ?? '',
                    'description' => $meta['description'] ?? null,
                    'status' => 'approved',
                ]
            );

            $staleIds = Publication::query()->orderByDesc('id')->pluck('id')->slice(self::MAX_ITEMS)->values();
            if ($staleIds->isNotEmpty()) {
                Publication::whereIn('id', $staleIds)->delete();
            }

            return $pub;
        });

        $pub->load(['translations' => fn ($query) => $query
            ->where('locale', $locale)
            ->where('status', 'approved')]);

        return response()->json(['data' => $this->present($pub, 0, $pub->translations->first())], 201);
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
