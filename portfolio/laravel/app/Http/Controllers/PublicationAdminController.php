<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicationAdminController extends Controller
{
    public function index(): View
    {
        $publications = Publication::query()->orderByDesc('id')->get();

        return view('admin.publications', compact('publications'));
    }

    public function edit(Publication $publication): View
    {
        return view('admin.publication-edit', compact('publication'));
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();

        return redirect()
            ->route('publications.admin.index')
            ->with('status', 'Publication deleted.');
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
            ->route('publications.admin.index')
            ->with('status', 'Publication updated.');
    }
}
