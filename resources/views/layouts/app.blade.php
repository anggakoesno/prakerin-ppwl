<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Prakerin') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; color: #1b1b18; }
        nav { background: #fff; border-bottom: 1px solid #e3e3e0; padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 1.5rem; }
        nav .brand { font-weight: 600; text-decoration: none; color: #1b1b18; }
        nav a { text-decoration: none; color: #444; font-size: 0.9rem; }
        nav a:hover { color: #1b1b18; }
        main { max-width: 960px; margin: 2rem auto; padding: 0 1.5rem; }
        h1 { font-size: 1.4rem; margin-bottom: 1rem; }
        .card { background: #fff; border: 1px solid #e3e3e0; border-radius: 6px; padding: 1.25rem; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('dashboard') }}" class="brand">{{ config('app.name', 'Prakerin') }}</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('kompetensi.index') }}">Kompetensi</a>
        <form method="GET" action="{{ route('search.index') }}" style="margin-left: auto; display: flex; gap: 0.5rem;">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari..."
                style="padding: 0.3rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.85rem;"
            >
            <button type="submit" style="padding: 0.3rem 0.75rem; background: #1b1b18; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">Cari</button>
        </form>
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>
