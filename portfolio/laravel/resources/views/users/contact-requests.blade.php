<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>درخواست‌های تماس | پنل مدیریت</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 1100px; margin: 0 auto; }
        header { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0; color: #64717d; }
        .count { white-space: nowrap; color: #087f72; font-weight: 700; }
        .table-wrap { overflow-x: auto; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 14px 16px; text-align: right; vertical-align: top; border-bottom: 1px solid #e8ecef; }
        th { background: #f8fafb; color: #56636e; font-size: 13px; }
        td { line-height: 1.8; }
        tbody tr:last-child td { border-bottom: 0; }
        .message { min-width: 280px; white-space: pre-wrap; overflow-wrap: anywhere; }
        .delete-btn { font: inherit; padding: 6px 14px; border: 1px solid #d64545; border-radius: 5px; background: #fff; color: #d64545; cursor: pointer; }
        .delete-btn:hover { background: #d64545; color: #fff; }
        .status { margin-bottom: 16px; padding: 12px 16px; background: #e6f6f4; border: 1px solid #087f72; border-radius: 8px; color: #087f72; }
        .empty { padding: 36px; text-align: center; color: #64717d; }
        .pagination { margin-top: 20px; }
        .pagination nav > div:first-child { display: none; }
        .pagination a, .pagination span[aria-current] span { display: inline-block; padding: 7px 12px; margin-left: 4px; background: white; border: 1px solid #dce2e7; border-radius: 5px; color: #17212b; text-decoration: none; }
        .chart-card { background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 16px; margin-bottom: 24px; }
        .chart-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
        .chart-head h2 { margin: 0; font-size: 18px; }
        .chart-tabs button { font: inherit; padding: 6px 14px; margin-right: 6px; border: 1px solid #dce2e7; border-radius: 5px; background: #fff; cursor: pointer; }
        .chart-tabs button.active { background: #087f72; border-color: #087f72; color: #fff; }
        .chart-box { position: relative; height: 320px; }
        @media (max-width: 600px) { body { padding: 22px 12px; } header { align-items: start; flex-direction: column; } }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => 'visitors'])
<div class="dash-content">
<main>
    <header>
        <div>
            <h1>درخواست‌های تماس</h1>
            <p>پیام‌های ارسال‌شده از فرم وب‌سایت</p>
        </div>
        <div class="count">
            <div>{{ number_format($visitorsCount) }} بازدیدکنندها آمار</div>
            <div>{{ $requests->total() }} درخواست</div>
        </div>
    </header>

    <section class="chart-card">
        <div class="chart-head">
            <h2>آمار بازدیدکنندگان</h2>
            <div class="chart-tabs">
                <button type="button" data-range="daily" class="active">روزانه</button>
                <button type="button" data-range="weekly">هفتگی</button>
                <button type="button" data-range="monthly">ماهانه</button>
            </div>
        </div>
        <div class="chart-box"><canvas id="visitorsChart"></canvas></div>
    </section>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <div class="table-wrap">
        @if ($requests->isEmpty())
            <div class="empty">هنوز درخواستی ثبت نشده است.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>شماره تماس</th>
                        <th>ایمیل</th>
                        <th>پیام</th>
                        <th>زمان ثبت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $contactRequest)
                        <tr>
                            <td>{{ $contactRequest->name }}</td>
                            <td dir="ltr">{{ $contactRequest->phone ?? '—' }}</td>
                            <td dir="ltr">{{ $contactRequest->email ?? '—' }}</td>
                            <td class="message">{{ $contactRequest->message }}</td>
                            <td>{{ $contactRequest->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('contact-requests.destroy', $contactRequest) }}" onsubmit="return confirm('این درخواست حذف شود؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="pagination">{{ $requests->links() }}</div>
</main>
</div>
</div>
<script src="{{ asset('assets/js/chart.umd.min.js') }}"></script>
<script>
    const series = @json($chart);
    const titles = { daily: 'روزانه', weekly: 'هفتگی (از شنبه)', monthly: 'ماهانه' };
    const chart = new Chart(document.getElementById('visitorsChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: '', data: [], fill: false, borderColor: 'rgb(75, 192, 192)', tension: 0.1 }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
    function show(range) {
        chart.data.labels = series[range].labels;
        chart.data.datasets[0].data = series[range].data;
        chart.data.datasets[0].label = 'بازدیدکننده  - ' + titles[range];
        chart.update();
        document.querySelectorAll('.chart-tabs button').forEach(b => b.classList.toggle('active', b.dataset.range === range));
    }
    document.querySelectorAll('.chart-tabs button').forEach(b => b.addEventListener('click', () => show(b.dataset.range)));
    show('daily');
</script>
</body>
</html>