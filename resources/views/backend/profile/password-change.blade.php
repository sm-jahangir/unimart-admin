@extends('layouts.backend.app')

@section('title', 'Change Password')

@section('page', 'profile')

@section('content')
        <div class="mb-6">
          <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Account</p>
          <h1 class="text-[24px] font-semibold text-ink-900">Change Password</h1>
          <p class="mt-1 text-[14px] text-ink-500">You will be logged out after changing your password.</p>
        </div>

        @if ($errors->any())
          <div class="mb-6 rounded-base border border-danger-600/30 bg-danger-50 px-4 py-3 text-[13px] text-danger-600">
            <ul class="list-inside list-disc space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <section>
          <form
            action="{{ route('app.profile.password.update') }}"
            method="POST"
            class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
          >
            @csrf

            <div class="border-b border-surface-line pb-5">
              <h2 class="text-[20px] font-medium text-ink-900">Password</h2>
              <p class="mt-1 text-[14px] text-ink-500">Choose a strong password of at least 8 characters.</p>
            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
              <label class="block">
                <span class="text-[14px] font-semibold text-ink-700">Current Password</span>
                <input
                  name="current_password"
                  type="password"
                  required
                  autocomplete="current-password"
                  class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                />
                @error('current_password')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <div class="space-y-5">
                <label class="block">
                  <span class="text-[14px] font-semibold text-ink-700">New Password</span>
                  <input
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                  />
                  @error('password')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                </label>
                <label class="block">
                  <span class="text-[14px] font-semibold text-ink-700">Confirm New Password</span>
                  <input
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                  />
                </label>
              </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-2">
              <a
                href="{{ route('app.profile.index') }}"
                class="inline-flex h-11 items-center rounded-base border border-surface-line px-5 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
                >Cancel</a
              >
              <button
                type="submit"
                class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
              >
                <i data-lucide="shield" class="h-4 w-4"></i>
                Update Password
              </button>
            </div>
          </form>
        </section>
      @endsection
