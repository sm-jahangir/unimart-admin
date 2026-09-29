@extends('layouts.backend.app')

@section('title', 'Profile')

@section('page', 'profile')

@section('content')
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Account</p>
            <h1 class="text-[24px] font-semibold text-ink-900">Profile</h1>
            <p class="mt-1 text-[14px] text-ink-500">Update your name, email address, and profile photo.</p>
          </div>
          <a
            href="{{ route('app.profile.password') }}"
            class="inline-flex h-11 items-center gap-2 rounded-base border border-surface-line px-4 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
          >
            <i data-lucide="shield" class="h-4 w-4"></i>
            Change Password
          </a>
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
            action="{{ route('app.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
          >
            @csrf
            <div class="border-b border-surface-line pb-5">
              <h2 class="text-[20px] font-medium text-ink-900">Your Profile</h2>
              <p class="mt-1 text-[14px] text-ink-500">These details identify you across the dashboard.</p>
            </div>

            <div class="mt-6 flex items-center gap-4">
              <img
                src="{{ auth()->user()->avatarUrl() }}"
                alt="{{ auth()->user()->name }}"
                class="h-16 w-16 rounded-full object-cover"
              />
              <div>
                <label class="inline-flex h-11 cursor-pointer items-center gap-2 rounded-base border border-surface-line px-4 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted">
                  <i data-lucide="upload" class="h-4 w-4"></i>
                  Choose Photo
                  <input type="file" name="avatar" accept="image/*" class="hidden" />
                </label>
                <p class="mt-1.5 text-[12px] text-ink-500">PNG or JPG, max 2MB. Square images look best.</p>
                @error('avatar')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </div>
            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
              <label class="block">
                <span class="text-[14px] font-semibold text-ink-700">Name</span>
                <input
                  name="name"
                  value="{{ old('name', auth()->user()->name) }}"
                  required
                  class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                />
                @error('name')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <label class="block">
                <span class="text-[14px] font-semibold text-ink-700">Email</span>
                <input
                  name="email"
                  type="email"
                  value="{{ old('email', auth()->user()->email) }}"
                  required
                  class="mt-2 h-11 w-full rounded-base border border-surface-line bg-surface-body px-4 text-[14px] focus:border-brand-600"
                />
                @error('email')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-2">
              <button
                type="submit"
                class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
              >
                <i data-lucide="save" class="h-4 w-4"></i>
                Save Changes
              </button>
            </div>
          </form>
        </section>
      @endsection
