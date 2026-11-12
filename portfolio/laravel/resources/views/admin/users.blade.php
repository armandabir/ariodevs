<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users | Admin</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; }
        .dash-layout { display: flex; align-items: flex-start; gap: 24px; max-width: 1200px; margin: 0 auto; }
        .dash-content { flex: 1; min-width: 0; }
        main { max-width: 900px; margin: 0 auto; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        h2 { margin: 0 0 12px; font-size: 18px; }
        p { margin: 0 0 24px; color: #64717d; }
        .panel { background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 24px; margin-bottom: 24px; }
        .table-wrap { overflow-x: auto; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e8ecef; }
        th { background: #f8fafb; color: #56636e; font-size: 13px; }
        .field { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; color: #56636e; }
        input, select { width: 100%; font: inherit; padding: 10px 12px; border: 1px solid #dce2e7; border-radius: 5px; background: #fff; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 16px; }
        .error { margin-top: 6px; color: #d64545; font-size: 13px; }
        button { font: inherit; padding: 10px 20px; border: 0; border-radius: 5px; background: #087f72; color: #fff; cursor: pointer; }
        .status { margin-bottom: 16px; padding: 12px 16px; background: #e6f6f4; border: 1px solid #087f72; border-radius: 8px; color: #087f72; }
        .role { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; background: #e6f6f4; color: #087f72; }
        .role.user { background: #f4f6f8; color: #56636e; }
        @media (max-width: 600px) { body { padding: 22px 12px; } .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => 'users'])
<div class="dash-content">
<main>
    <h1>Users</h1>
    <p>Create admin or regular users</p>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <div class="panel">
        <h2>Add user</h2>
        <form method="POST" action="{{ route('publications.admin.users.store') }}">
            @csrf
            <div class="grid">
                <div class="field">
                    <label for="name">Username</label>
                    <input id="name" name="name" type="text" maxlength="255" required value="{{ old('name') }}">
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" maxlength="255" required value="{{ old('email') }}">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="password">Password (min 8 characters)</label>
                    <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password">
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="user" @selected(old('role') === 'user')>User</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                    @error('role') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            <button type="submit">Create user</button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Username</th><th>Email</th><th>Role</th></tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="role {{ $user->is_admin ? '' : 'user' }}">{{ $user->is_admin ? 'Admin' : 'User' }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
</div>
</div>
</body>
</html>
