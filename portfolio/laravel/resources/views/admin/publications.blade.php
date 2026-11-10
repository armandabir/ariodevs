<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Publications | Admin</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; }
        .dash-layout { display: flex; align-items: flex-start; gap: 24px; max-width: 1400px; margin: 0 auto; }
        .dash-content { flex: 1; min-width: 0; }
        main { max-width: 1100px; margin: 0 auto; }
        header { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0; color: #64717d; }
        .count { white-space: nowrap; color: #087f72; font-weight: 700; }
        .table-wrap { overflow-x: auto; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 14px 16px; text-align: left; vertical-align: top; border-bottom: 1px solid #e8ecef; }
        th { background: #f8fafb; color: #56636e; font-size: 13px; }
        td { line-height: 1.8; }
        tbody tr:last-child td { border-bottom: 0; }
        .url { max-width: 320px; overflow-wrap: anywhere; font-size: 13px; color: #64717d; }
        .actions { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        .edit-link, .delete-btn { display: inline-block; padding: 6px 14px; border-radius: 5px; font: inherit; }
        .edit-link { border: 1px solid #087f72; color: #087f72; text-decoration: none; }
        .edit-link:hover { background: #087f72; color: #fff; }
        .delete-btn { border: 1px solid #d64545; background: #fff; color: #d64545; cursor: pointer; }
        .delete-btn:hover { background: #d64545; color: #fff; }
        .logout { font: inherit; padding: 6px 14px; border: 1px solid #56636e; border-radius: 5px; background: #fff; color: #56636e; cursor: pointer; }
        .status { margin-bottom: 16px; padding: 12px 16px; background: #e6f6f4; border: 1px solid #087f72; border-radius: 8px; color: #087f72; }
        .empty { padding: 36px; text-align: center; color: #64717d; }
        @media (max-width: 600px) { body { padding: 22px 12px; } header { align-items: start; flex-direction: column; } }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => 'publications'])
<div class="dash-content">
<main>
    <header>
        <div>
            <h1>Publications</h1>
            <p>Edit the articles shown on the site</p>
        </div>
        <div class="count">{{ $publications->count() }} articles</div>
        <form method="POST" action="{{ route('publications.admin.logout') }}">
            @csrf
            <button type="submit" class="logout">Sign out</button>
        </form>
    </header>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <div class="table-wrap">
        @if ($publications->isEmpty())
            <div class="empty">No publications yet.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Venue</th>
                        <th>Category</th>
                        <th>URL</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publications as $publication)
                        <tr>
                            <td>{{ $publication->title }}</td>
                            <td>{{ $publication->venue }}</td>
                            <td>{{ $publication->category }}</td>
                            <td class="url">{{ $publication->url }}</td>
                            <td>
                                <div class="actions">
                                    <a class="edit-link" href="{{ route('publications.admin.edit', $publication) }}">Edit</a>
                                    <form method="POST" action="{{ route('publications.admin.destroy', $publication) }}" onsubmit="return confirm('Delete this publication?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>
</div>
</div>
</body>
</html>
