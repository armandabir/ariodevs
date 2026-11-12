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
        main { width: 100%; margin: 0 auto; }
        h1 { margin: 0 0 8px; font-size: 24px; }
        p { margin: 0 0 24px; color: #64717d; }
        .card { background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 24px; margin-bottom: 24px; }
        form.card { margin: 0; width: 100%; }
        .visibility form, .translations form { background: none; border: 0; padding: 0; width: auto; }
        .actions form { margin: 0; padding: 0; border: 0; background: none; }
        .section form { margin: 0; }
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
        .status { margin-bottom: 16px; padding: 12px 16px; background: #e6f6f4; border: 1px solid #087f72; border-radius: 8px; color: #087f72; }
        .state-btn { font-size: 13px; padding: 6px 14px; }
        .state-btn.ok { background: #087f72; } .state-btn.off { background: #fff; color: #56636e; border: 1px solid #56636e; }
        .section { margin-top: 32px; }
        .section-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 12px; }
        h2 { margin: 0; font-size: 18px; }
        @media (max-width: 600px) { body { padding: 22px 12px; } }
    </style>
</head>
<body>
<div class="dash-layout">
@include('users.partials.sidebar', ['active' => 'publications'])
<div class="dash-content">
<main>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <h1>Edit publication</h1>
    <p>The URL is fixed. To change it, add a new publication.</p>

    <form class="card" method="POST" action="{{ route('publications.admin.update', $publication) }}">
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

    <div class="card visibility">
        <div class="section-head">
            <h2>Visibility</h2>
            <form method="POST" action="{{ route('publications.admin.publish', $publication) }}">
                @csrf
                <button type="submit" class="state-btn {{ $publication->is_published ? 'ok' : 'off' }}">{{ $publication->is_published ? 'Published: click to unpublish' : 'Unpublished: click to publish' }}</button>
            </form>
        </div>
    </div>

    <div class="translations">
    @foreach (['fa' => 'Persian (FA)', 'en' => 'English (EN)'] as $locale => $label)
        @php($translation = $translations->get($locale))
        <div class="card" dir="{{ $locale === 'fa' ? 'rtl' : 'ltr' }}" lang="{{ $locale }}">
            <form method="POST" action="{{ route('publications.admin.translation.update', [$publication, $locale]) }}">
                @csrf
                @method('PUT')
                <div class="section-head">
                    <h2>{{ $label }}</h2>
                    <span class="{{ $translation && $translation->status === 'approved' ? 'ok' : 'off' }}">{{ $translation ? $translation->status : 'missing' }}</span>
                </div>
                <div class="field">
                    <label for="{{ $locale }}-title">Title</label>
                    <input id="{{ $locale }}-title" name="title" type="text" maxlength="500" required value="{{ old('title', $translation->title ?? '') }}">
                </div>
                <div class="field">
                    <label for="{{ $locale }}-venue">Venue</label>
                    <input id="{{ $locale }}-venue" name="venue" type="text" maxlength="255" value="{{ old('venue', $translation->venue ?? '') }}">
                </div>
                <div class="field">
                    <label for="{{ $locale }}-category">Category</label>
                    <input id="{{ $locale }}-category" name="category" type="text" maxlength="255" value="{{ old('category', $translation->category ?? '') }}">
                </div>
                <div class="field">
                    <label for="{{ $locale }}-description">Description</label>
                    <textarea id="{{ $locale }}-description" name="description" maxlength="1000">{{ old('description', $translation->description ?? '') }}</textarea>
                </div>
                <div class="actions">
                    <button type="submit">Save {{ strtoupper($locale) }} translation</button>
                </div>
            </form>
            @if ($translation)
                <form method="POST" action="{{ route('publications.admin.translation.status', [$publication, $locale]) }}" style="margin-top:12px;">
                    @csrf
                    <button type="submit" class="state-btn {{ $translation->status === 'approved' ? 'ok' : 'off' }}">{{ $translation->status === 'approved' ? 'Approved: click to set draft' : 'Draft: click to approve' }}</button>
                </form>
            @endif
        </div>
    @endforeach
    </div>
</main>
</div>
</div>
</body>
</html>