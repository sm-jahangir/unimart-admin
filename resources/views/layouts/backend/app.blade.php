<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Unimart-inspired Tailwind admin dashboard HTML template." />
    <meta name="theme-color" content="#215ada" />
    <meta name="color-scheme" content="light dark" />
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    @stack('head')
    <title>@yield('title', 'Dashboard') | Unimart Admin</title>
    <script>
      try {
        var d = document.documentElement;
        if (localStorage.getItem('unimart-theme') === 'dark') d.classList.add('dark');
        if (localStorage.getItem('unimart-sidebar-collapsed') === '1') d.classList.add('sidebar-collapsed');
      } catch (e) {}
    </script>
    {{-- Backend styles + any future backend JS, compiled by Vite (resources/js/backend/app.js) --}}
    @vite('resources/js/backend/app.js')
    <script defer src="{{ asset('backend/assets/main.bundle.js') }}"></script>
  </head>
  <body data-page="@yield('page', 'dashboard')" data-sidebar-open="false">
    <x-backend.preloader />
    <x-backend.sidebar />

    <div class="min-h-screen lg:pl-sidebar">
      <x-backend.header />

      <main class="px-4 py-6 lg:px-6 min-h-[calc(100vh-140px)]">
        @yield('content')
      </main>

      <x-backend.footer />
    </div>

    @stack('modals')

    {{-- Flash messages (replaces the notify() package) --}}
    @if (session('success') || session('error'))
        @php($flash = session('success') ? ['success', session('success')] : ['error', session('error')])
        <div id="app-flash" role="status"
             class="fixed bottom-4 right-4 z-[9999] rounded-base border px-4 py-3 text-[13px] font-semibold shadow-card {{ $flash[0] === 'success' ? 'border-success-600/30 bg-success-50 text-success-700' : 'border-danger-600/30 bg-danger-50 text-danger-600' }}">
            {{ $flash[1] }}
        </div>
        <script>setTimeout(() => document.getElementById('app-flash')?.remove(), 4000);</script>
    @endif
  </body>

</html>
