<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CountUniqueVisitor
{
    public const COOKIE = 'visitor_id';

    // A refresh within this window is not counted as another visit.
    private const VISIT_WINDOW_MINUTES = 30;

    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('GET') && ! $this->isBot($request)) {
            $this->track($request);
        }

        return $next($request);
    }

    private function track(Request $request): void
    {
        $id = $request->cookie(self::COOKIE);

        if (! is_string($id) || ! Str::isUuid($id)) {
            $id = (string) Str::uuid();
        }

        $token = hash('sha256', $id);
        $visitor = Visitor::where('token', $token)->first();

        if ($visitor) {
            if (! $visitor->last_seen_at || $visitor->last_seen_at->diffInMinutes(now()) >= self::VISIT_WINDOW_MINUTES) {
                $visitor->visits++;
            }
            $visitor->last_seen_at = now();
            $visitor->save();
        } else {
            try {
                Visitor::create([
                    'token' => $token,
                    'ip' => $request->ip(),
                    'last_seen_at' => now(),
                ]);
            } catch (QueryException $e) {
                // A concurrent request already stored this visitor.
            }
        }

        // Remember the visitor for one year (minutes).
        Cookie::queue(self::COOKIE, $id, 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'Lax');
    }

    private function isBot(Request $request): bool
    {
        return (bool) preg_match('/bot|crawl|spider|slurp|curl|wget|headless/i', (string) $request->userAgent());
    }
}
