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
        .empty { padding: 36px; text-align: center; color: #64717d; }
        .pagination { margin-top: 20px; }
        .pagination nav > div:first-child { display: none; }
        .pagination a, .pagination span[aria-current] span { display: inline-block; padding: 7px 12px; margin-left: 4px; background: white; border: 1px solid #dce2e7; border-radius: 5px; color: #17212b; text-decoration: none; }
        @media (max-width: 600px) { body { padding: 22px 12px; } header { align-items: start; flex-direction: column; } }
    </style>
</head>
<body>
<main>
    <header>
        <div>
            <h1>درخواست‌های تماس</h1>
            <p>پیام‌های ارسال‌شده از فرم وب‌سایت</p>
        </div>
        <div class="count">{{ $requests->total() }} درخواست</div>
    </header>

    <div class="table-wrap">
        @if ($requests->isEmpty())
            <div class="empty">هنوز درخواستی ثبت نشده است.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>پیام</th>
                        <th>زمان ثبت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $contactRequest)
                        <tr>
                            <td>{{ $contactRequest->name }}</td>
                            <td dir="ltr">{{ $contactRequest->email }}</td>
                            <td class="message">{{ $contactRequest->message }}</td>
                            <td>{{ $contactRequest->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="pagination">{{ $requests->links() }}</div>
</main>
</body>
</html>