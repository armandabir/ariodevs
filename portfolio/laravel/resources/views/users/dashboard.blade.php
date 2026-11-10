<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; }
        main { max-width: 720px; margin: 0 auto; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 28px; }
        header { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        h1 { margin: 0; font-size: 22px; }
        p { color: #64717d; }
        .logout { font: inherit; padding: 6px 14px; border: 1px solid #56636e; border-radius: 5px; background: #fff; color: #56636e; cursor: pointer; }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => null])
<div class="dash-content">
<main>
    <header>
        <h1>Welcome, {{ session('username') }}</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Sign out</button>
        </form>
    </header>
    <p>Your dashboard is coming soon.</p>
    <p>Visitors: <strong id="visitorCount">{{ number_format($visitorsCount) }}</strong></p>
    <script>
        fetch(@json(route('users.dashboard.visitor-count')), { headers: { Accept: 'application/json' } })
            .then((res) => (res.ok ? res.json() : null))
            .then((data) => {
                if (data) document.getElementById('visitorCount').textContent = Number(data.visitors).toLocaleString();
            })
            .catch(() => {});
    </script>
</main>
</div>
</div>
</body>
</html>
