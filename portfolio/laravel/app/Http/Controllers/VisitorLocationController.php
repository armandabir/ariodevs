<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CountUniqueVisitor;
use App\Models\Visitor;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class VisitorLocationController extends Controller
{
    public function count()
    {
        return response()->json([
            'visitors' => Visitor::count(),
        ])->header('Cache-Control', 'no-store');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'timezone' => ['nullable', 'string', 'max:64', 'timezone'],
        ]);

        $id = $request->cookie(CountUniqueVisitor::COOKIE);
        $visitor = is_string($id) && Str::isUuid($id)
            ? Visitor::where('token', hash('sha256', $id))->first()
            : null;

        if (! $visitor) {
            return response()->noContent();
        }

        if (! empty($data['timezone'])) {
            $visitor->timezone = $data['timezone'];
            $visitor->timezone_name = Visitor::readableTimezone($data['timezone']);
        }

        // Look the IP up once; refreshes and returning visits reuse the stored result.
        if (! $visitor->country && $visitor->ip
            && filter_var($visitor->ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            try {
                $geo = Http::timeout(3)
                    ->get('http://ip-api.com/json/'.$visitor->ip, ['fields' => 'status,country,city,timezone'])
                    ->json();

                if (($geo['status'] ?? null) === 'success') {
                    $visitor->country = $geo['country'] ?? null;
                    $visitor->city = $geo['city'] ?? null;
                    $visitor->ip_timezone = $geo['timezone'] ?? null;
                }
            } catch (\Throwable $e) {
                // Location is optional; ignore lookup failures.
            }
        }

        $visitor->vpn_suspected = $this->differentCountry($visitor->timezone, $visitor->ip_timezone);
        $visitor->save();

        return response()->noContent();
    }

    // Compare countries, not raw names, so aliases like Asia/Calcutta vs Asia/Kolkata don't false-flag.
    private function differentCountry(?string $browserTz, ?string $ipTz): bool
    {
        if (! $browserTz || ! $ipTz) {
            return false;
        }

        $a = (new DateTimeZone($browserTz))->getLocation()['country_code'] ?? '??';
        $b = (new DateTimeZone($ipTz))->getLocation()['country_code'] ?? '??';

        return $a !== '??' && $b !== '??' && $a !== $b;
    }
}
