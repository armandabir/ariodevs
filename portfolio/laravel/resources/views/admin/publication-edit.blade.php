<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit publication | Admin</title>
    <style>
        :root { color-scheme: light; font-family: Tahoma, sans-serif; background: #f4f6f8; color: #17212b; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; }
        .dash-layout { display: flex; align-items: flex-start; gap: 24px; max-width: 1200px; margin: 0 auto; }
        .dash-content { flex: 1; min-width: 0; }
        main { max-width: 720px; margin: 0 auto; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0 0 24px; color: #64717d; }
        form { background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 24px; }
        .field { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; color: #56636e; }
        input, textarea { width: 100%; font: inherit; padding: 10px 12px; border: 1px solid #dce2e7; border-radius: 5px; background: #fff; }
        textarea { min-height: 120px; resize: vertical; }
        input[readonly] { background: #f8fafb; color: #64717d; }
        .error { margin-top: 6px; color: #d64545; font-size: 13px; }
        .actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        button { font: inherit; padding: 10px 20px; border: 0; border-radius: 5px; background: #087f72; color: #fff; cursor: pointer; }
        .delete-btn { border: 1px solid #d64545; background: #fff; color: #d64545; }
        .delete-btn:hover { background: #d64545; color: #fff; }
        a.back { color: #087f72; text-decoration: none; }
        @media (max-width: 600px) { body { padding: 22px 12px; } }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => 'publications'])
<div class="dash-content">
<main>
    <h1>Edit publication</h1>
    <p>The URL is fixed. To change it, add a new publication.</p>

    <form method="POST" action="{{ route('publications.admin.update', $publication) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="url">URL</label>
            <input id="url" type="text" value="{{ $publication->url }}" readonly>
        </div>

        <div class="field">
            <label for="title">Title</label>
            <input id="title" name="title" type="text" maxlength="500" required value="{{ old('title', $publication->title) }}">
            @error('title') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="venue">Venue</label>
            <input id="venue" name="venue" type="text" maxlength="255" value="{{ old('venue', $publication->venue) }}">
            @error('venue') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="category">Category</label>
            <input id="category" name="category" type="text" maxlength="255" value="{{ old('category', $publication->category) }}">
            @error('category') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="icon">Icon (Font Awesome class)</label>
            <input id="icon" name="icon" type="text" maxlength="255" required value="{{ old('icon', $publication->icon) }}">
            @error('icon') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" maxlength="1000">{{ old('description', $publication->description) }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit">Save</button>
            <a class="back" href="{{ route('publications.admin.index') }}">Back to list</a>
            <form method="POST" action="{{ route('publications.admin.destroy', $publication) }}" onsubmit="return confirm('Delete this publication?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">Delete publication</button>
            </form>
        </div>
    </form>
</main>
</div>
</div>
</body>
</html>
