<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Unimart admin panel." />
    <meta name="theme-color" content="#215ada" />
    <meta name="color-scheme" content="light dark" />
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <title>@yield('title', 'Sign in') | Unimart Admin</title>
    <script>
      try {
        var d = document.documentElement;
        if (localStorage.getItem('unimart-theme') === 'dark') d.classList.add('dark');
      } catch (e) {}
    </script>
    {{-- Backend theme styles, compiled by Vite (resources/js/backend/app.js) --}}
    @vite('resources/js/backend/app.js')
</head>

<body class="bg-surface-body">
    <main class="grid min-h-screen lg:grid-cols-[minmax(0,0.9fr)_minmax(460px,1fr)]">
        @yield('content')
    </main>

    @stack('modals')

    {{-- Flash messages --}}
    @if (session('success') || session('error'))
        @php($flash = session('success') ? ['success', session('success')] : ['error', session('error')])
        <div id="app-flash" role="status"
             class="fixed bottom-4 right-4 z-9999 rounded-base border px-4 py-3 text-[13px] font-semibold shadow-card {{ $flash[0] === 'success' ? 'border-success-600/30 bg-success-50 text-success-700' : 'border-danger-600/30 bg-danger-50 text-danger-600' }}">
            {{ $flash[1] }}
        </div>
        <script>setTimeout(() => document.getElementById('app-flash')?.remove(), 4000);</script>
    @endif
</body>

</html>
