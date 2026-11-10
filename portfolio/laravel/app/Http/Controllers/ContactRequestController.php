<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactRequestController extends Controller
{
    private const CHART_START = '2026-10-10';

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9۰-۹٠-٩+\-\s()]{7,30}$/u'],
            'email' => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactRequest::create($validated);

        return response()->json(['message' => 'درخواست شما ثبت شد.'], 201);
    }

    public function index(): View
    {
        $requests = ContactRequest::latest()->paginate(25);

        $visitorsCount = Visitor::count();

        $chart = $this->visitorsChart();

        return view('users.contact-requests', compact('requests', 'visitorsCount', 'chart'));
    }

    public function destroy(ContactRequest $contactRequest): RedirectResponse
    {
        $contactRequest->delete();

        return back()->with('status', 'درخواست حذف شد.');
    }

    private function visitorsChart(): array
    {
        $today = Carbon::today();
        $firstDay = Carbon::parse(self::CHART_START)->startOfDay();
        $firstWeek = $firstDay->copy()->startOfWeek(Carbon::SATURDAY);
        $firstMonth = $firstDay->copy()->startOfMonth();

        // Unique visitors are counted on the day their row was first created.
        $perDay = Visitor::where('created_at', '>=', $firstDay)
            ->get(['created_at'])
            ->countBy(fn ($v) => $v->created_at->toDateString());

        $daily = [];
        for ($d = $firstDay->copy(); $d->lte($today); $d->addDay()) {
            $daily[$d->toDateString()] = $perDay[$d->toDateString()] ?? 0;
        }

        $weekly = [];
        for ($w = $firstWeek->copy(); $w->lte($today); $w->addWeek()) {
            $weekly[$w->toDateString()] = 0;
        }
        $monthly = [];
        for ($m = $firstMonth->copy(); $m->lte($today); $m->addMonth()) {
            $monthly[$m->format('Y-m')] = 0;
        }

        foreach ($perDay as $date => $count) {
            $d = Carbon::parse($date);
            $week = $d->copy()->startOfWeek(Carbon::SATURDAY)->toDateString();
            $month = $d->format('Y-m');
            if (isset($weekly[$week])) {
                $weekly[$week] += $count;
            }
            if (isset($monthly[$month])) {
                $monthly[$month] += $count;
            }
        }

        $format = fn (array $s) => ['labels' => array_keys($s), 'data' => array_values($s)];

        return ['daily' => $format($daily), 'weekly' => $format($weekly), 'monthly' => $format($monthly)];
    }
}