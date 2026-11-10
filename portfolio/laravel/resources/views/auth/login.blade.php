<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 16px; }
        form { width: 100%; max-width: 360px; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 28px; }
        h1 { margin: 0 0 20px; font-size: 20px; }
        .field { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; color: #56636e; }
        input { width: 100%; font: inherit; padding: 10px 12px; border: 1px solid #dce2e7; border-radius: 5px; }
        .error { margin-bottom: 16px; padding: 10px 12px; background: #fdecec; border: 1px solid #d64545; border-radius: 5px; color: #d64545; font-size: 14px; }
        button { width: 100%; font: inherit; padding: 10px; border: 0; border-radius: 5px; background: #087f72; color: #fff; cursor: pointer; }
    </style>
</head>
<body>
<form method="POST" action="{{ route('login.submit') }}">
    @csrf
    <h1>Sign in</h1>

    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror

    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" autocomplete="username" required value="{{ old('username') }}">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>

    <button type="submit">Sign in</button>
</form>
</body>
</html>
