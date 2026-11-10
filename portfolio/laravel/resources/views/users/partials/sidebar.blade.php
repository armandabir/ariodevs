<style>
    .dash-layout { display: flex; align-items: flex-start; gap: 24px; max-width: 1200px; margin: 0 auto; }
    .dash-sidebar { display: flex; flex-direction: column; gap: 4px; width: 200px; flex-shrink: 0; background: #fff; border: 1px solid #dce2e7; border-radius: 8px; padding: 12px; }
    .dash-sidebar a { display: block; padding: 10px 12px; border-radius: 5px; color: #17212b; text-decoration: none; }
    .dash-sidebar a:hover { background: #f4f6f8; }
    .dash-sidebar a.active { background: #087f72; color: #fff; }
    .dash-content { flex: 1; min-width: 0; }
    @media (max-width: 600px) { .dash-layout { flex-direction: column; } .dash-sidebar { width: 100%; } }
</style>
<nav class="dash-sidebar" aria-label="Dashboard navigation">
    <a href="{{ route('users.dashboard.contact-requests') }}" class="{{ ($active ?? '') === 'visitors' ? 'active' : '' }}" @if (($active ?? '') === 'visitors') aria-current="page" @endif>Visitors</a>
    <a href="{{ route('publications.admin.index') }}" class="{{ ($active ?? '') === 'publications' ? 'active' : '' }}" @if (($active ?? '') === 'publications') aria-current="page" @endif>Publications</a>
</nav>
