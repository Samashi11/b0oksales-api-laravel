<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | BookSales</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #f1f5f9; color: #0f172a; }
        .topbar { background: #1d4ed8; }
        .topbar nav { max-width: 960px; margin: 0 auto; padding: 0 1rem; display: flex; gap: 1.25rem; align-items: center; height: 56px; }
        .topbar a { color: #fff; text-decoration: none; font-weight: 600; }
        .topbar a.brand { font-size: 1.15rem; margin-right: auto; }
        .page { max-width: 960px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
        .grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); margin-top: 1rem; }
        .kartu { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem; }
        .kartu h2 { margin: .25rem 0 .5rem; font-size: 1.1rem; color: #1e40af; }
        .kartu p { margin: .25rem 0; line-height: 1.5; }
        .redup { color: #64748b; font-size: .85rem; }
        .btn { display: inline-block; background: #1d4ed8; color: #fff; border: 0; border-radius: 6px; padding: .5rem .9rem; font: inherit; font-weight: 600; text-decoration: none; cursor: pointer; }
        .btn-bahaya { background: #b91c1c; }
        .aksi { display: flex; gap: .75rem; align-items: center; margin-top: .75rem; }
        .aksi form { margin: 0; }
        .form { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem; max-width: 560px; margin-top: 1rem; display: grid; gap: 1rem; }
        .form label { display: grid; gap: .35rem; font-weight: 600; }
        .form input, .form textarea { font: inherit; padding: .55rem; border: 1px solid #94a3b8; border-radius: 6px; width: 100%; }
        .pesan-ok { color: #166534; background: #dcfce7; padding: .6rem .8rem; border-radius: 6px; }
        .pesan-error { color: #991b1b; background: #fee2e2; padding: .6rem .8rem; border-radius: 6px; margin: .5rem 0; }
    </style>
</head>
<body>
    <header class="topbar">
        <nav aria-label="Menu utama">
            <a class="brand" href="{{ route('home') }}">BookSales</a>
            <a href="{{ route('books.page.index') }}">Buku</a>
            <a href="{{ route('genres.page.index') }}">Genre</a>
            <a href="{{ route('authors.page.index') }}">Author</a>
        </nav>
    </header>

    <main class="page">
        @if (session('status'))
            <p class="pesan-ok" role="status">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
