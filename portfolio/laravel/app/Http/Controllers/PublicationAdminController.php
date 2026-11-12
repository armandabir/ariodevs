<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PublicationTranslation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicationAdminController extends Controller
{
    private const LOCALES = ['fa', 'en'];

    public function index(): View
    {
        $publications = Publication::query()
            ->with('translations')
            ->orderByDesc('id')
            ->get();

        return view('admin.publications', compact('publications'));
    }

    public function edit(Publication $publication): View
    {
        $publication->load('translations');

        return view('admin.publication-edit', [
            'publication' => $publication,
            'translations' => $publication->translations->keyBy('locale'),
        ]);
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();

        return redirect()
            ->route('publications.admin.index')
            ->with('status', 'Publication deleted.');
    }

    public function togglePublish(Publication $publication): RedirectResponse
    {
        $publication->update(['is_published' => ! $publication->is_published]);

        return redirect()
            ->route('publications.admin.index')
            ->with('status', $publication->is_published ? 'Publication is now published.' : 'Publication is now unpublished.');
    }

    public function toggleTranslation(Publication $publication, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, self::LOCALES, true), 404);

        $translation = PublicationTranslation::query()
            ->where('publication_id', $publication->id)
            ->where('locale', $locale)
            ->firstOrFail();

        $translation->update([
            'status' => $translation->status === 'approved' ? 'draft' : 'approved',
        ]);

        return redirect()
            ->route('publications.admin.edit', $publication)
            ->with('status', strtoupper($locale).' translation is now '.$translation->status.'.');
    }

    public function update(Request $request, Publication $publication): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:500'],
            'venue' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $publication->update([
            'icon' => $validated['icon'],
            'title' => $validated['title'],
            'venue' => $validated['venue'] ?? '',
            'category' => $validated['category'] ?? '',
            'description' => $validated['description'] ?: null,
        ]);

        return redirect()
            ->route('publications.admin.edit', $publication)
            ->with('status', 'Publication updated.');
    }

    public function updateTranslation(Request $request, Publication $publication, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, self::LOCALES, true), 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:500'],
            'venue' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        PublicationTranslation::updateOrCreate(
            ['publication_id' => $publication->id, 'locale' => $locale],
            [
                'title' => $validated['title'],
                'venue' => $validated['venue'] ?? '',
                'category' => $validated['category'] ?? '',
                'description' => $validated['description'] ?: null,
                'status' => 'draft',
            ],
        );

        return redirect()
            ->route('publications.admin.edit', $publication)
            ->with('status', strtoupper($locale).' translation saved as draft. Approve it to show it.');
    }

    public function users(): View
    {
        return view('admin.users', ['users' => User::query()->orderBy('name')->get()]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $validated['role'] === 'admin',
        ]);

        return redirect()
            ->route('publications.admin.users')
            ->with('status', 'User created.');
    }
}