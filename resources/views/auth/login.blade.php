@extends('layouts.backend.auth')

@section('title', 'Sign in')

@section('content')
      <section
        class="hidden bg-gradient-to-b from-admin-sidebar to-admin-sidebar-dark p-10 text-white lg:flex lg:flex-col"
      >
        <a href="{{ route('app.dashboard') }}" class="inline-flex items-center" aria-label="Unimart dashboard">
          <img src="{{ asset('backend/assets/images/logo/logo-white.webp') }}" alt="Unimart" class="h-10 w-auto" />
        </a>
        <div class="mt-auto max-w-lg">
          <p class="text-[14px] font-semibold uppercase text-white/70">Admin workspace</p>
          <h1 class="mt-3 text-[38px] font-semibold leading-tight text-white">
            A calm command center for modern ecommerce teams.
          </h1>
          <p class="mt-4 text-[16px] leading-7 text-white/75">
            Manage catalog, orders, customers, and fulfillment with the same restrained Unimart visual language.
          </p>
        </div>
      </section>

      <section class="flex items-center justify-center px-4 py-10">
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-[440px] rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
          @csrf
          <a href="{{ url('/') }}" class="inline-flex items-center lg:hidden" aria-label="Unimart dashboard">
            <img src="{{ asset('backend/assets/images/logo/logo.webp') }}" alt="Unimart" class="h-9 w-auto" />
          </a>
          <div class="mt-8 lg:mt-0">
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Welcome back</p>
            <h2 class="text-[26px] font-semibold text-ink-900">Sign in to admin</h2>
            <p class="mt-2 text-[14px] text-ink-500">Enter your credentials to access the dashboard.</p>
          </div>

          @if ($errors->any())
            <div class="mt-5 rounded-base border border-danger-600/30 bg-danger-50 px-4 py-3 text-[13px] text-danger-600">
              <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mt-6 space-y-4">
            <label class="block">
              <span class="text-[14px] font-semibold text-ink-700">Email address</span>
              <input
                class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                autofocus
              />
              @error('email')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
            </label>
            <label class="block">
              <span class="text-[14px] font-semibold text-ink-700">Password</span>
              <input
                class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                type="password"
                name="password"
                required
                autocomplete="current-password"
              />
              @error('password')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
            </label>
          </div>

          <div class="mt-5 flex items-center justify-between gap-3 text-[14px]">
            <label class="flex items-center gap-2 text-ink-600">
              <input
                type="checkbox"
                name="remember"
                {{ old('remember') ? 'checked' : '' }}
                class="h-4 w-4 rounded border-surface-line text-brand-600 focus:ring-brand-600"
              />
              Remember me
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="font-semibold text-brand-600 hover:text-brand-700">Forgot password?</a>
            @endif
          </div>

          <button
            type="submit"
            class="mt-6 inline-flex h-11 w-full items-center justify-center rounded-base bg-brand-600 text-[14px] font-semibold text-white hover:bg-brand-700"
          >Sign In</button>
        </form>
      </section>
      @endsection
