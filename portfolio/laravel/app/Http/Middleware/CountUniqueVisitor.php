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
    private const COOKIE = 'visitor_id';

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

        try {
            Visitor::firstOrCreate(['token' => hash('sha256', $id)]);
        } catch (QueryException $e) {
            // A concurrent request already stored this visitor.
        }

        // Remember the visitor for one year (minutes).
        Cookie::queue(self::COOKIE, $id, 60 * 24 * 365, '/', null, $request->isSecure(), true, false, 'Lax');
    }

    private function isBot(Request $request): bool
    {
        return (bool) preg_match('/bot|crawl|spider|slurp|curl|wget|headless/i', (string) $request->userAgent());
    }
}
