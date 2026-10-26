<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, sans-serif;
            background: #ffffff;
            color: #1b1b18;
        }

        nav {
            background: #fff;
            border-bottom: 1px solid #e3e3e0;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        nav .brand {
            font-weight: 600;
            text-decoration: none;
            color: #1b1b18;
        }

        nav a {
            text-decoration: none;
            color: #444;
            font-size: 0.9rem;
        }

        nav a:hover {
            color: #1b1b18;
        }

        main {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        h1 {
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .card {
            background: #fff;
            border: 1px solid #e3e3e0;
            border-radius: 6px;
            padding: 1.25rem;
        }
    </style>
    <!-- Scripts and Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <nav>
        <a href="{{ route('dashboard') }}" class="brand">Prakerin</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('jurusan.index') }}">Jurusan</a>
        <a href="{{ route('kompetensi.index') }}">Kompetensi</a>

        <form method="GET" action="{{ route('search.index') }}" style="margin-left: auto; display: flex; gap: 0.5rem;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..."
                style="padding: 0.3rem 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.85rem;">
            <button type="submit"
                style="padding: 0.3rem 0.75rem; background: #1b1b18; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">Cari</button>
        </form>

        @guest
            <a href="{{ route('login') }}">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @else
            <span style="font-size: 0.9rem; color: #444;">{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @endguest
    </nav>
    <main>
        @if (session('success'))
            <div
                style="background: #e6f6e6; border: 1px solid #9fd89f; color: #1e6b23; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>

</html>
