@extends('layouts.backend.app')

@section('title', $user->exists ? 'Edit User' : 'Add User')

@section('page', 'users')

@section('content')
        <div class="mb-6">
          <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Access Control</p>
          <h1 class="text-[24px] font-semibold text-ink-900">{{ $user->exists ? 'Edit User' : 'Add User' }}</h1>
          <p class="mt-1 text-[14px] text-ink-500">
            {{ $user->exists ? "Update {$user->name}'s account and access." : 'Create a new dashboard account.' }}
          </p>
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

        <form
          id="user-form"
          action="{{ $user->exists ? route('app.users.update', $user) : route('app.users.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6"
        >
          @csrf
          @if ($user->exists)
            @method('PUT')
          @endif

          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Account Details</h2>

            <div class="flex items-center gap-4">
              <img
                src="{{ $user->avatarUrl() }}"
                alt="{{ $user->name }}"
                class="h-16 w-16 rounded-full object-cover"
              />
              <div>
                <label class="inline-flex h-11 cursor-pointer items-center gap-2 rounded-base border border-surface-line px-4 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted">
                  <i data-lucide="upload" class="h-4 w-4"></i>
                  Choose Photo
                  <input type="file" name="avatar" accept="image/*" class="hidden" />
                </label>
                <p class="mt-1.5 text-[12px] text-ink-500">PNG or JPG, max 2MB.</p>
                @error('avatar')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </div>
            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">Name <span class="text-danger-500">*</span></span>
                <input
                  required
                  name="name"
                  value="{{ old('name', $user->name) }}"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
                @error('name')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">Email <span class="text-danger-500">*</span></span>
                <input
                  required
                  name="email"
                  type="email"
                  value="{{ old('email', $user->email) }}"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
                @error('email')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">
                  Password
                  @if ($user->exists) <span class="font-normal text-ink-500">(leave empty to keep current)</span>@endif
                  <span class="text-danger-500">*</span>
                </span>
                <input
                  name="password"
                  type="password"
                  {{ $user->exists ? '' : 'required' }}
                  autocomplete="new-password"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
                @error('password')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">Confirm Password</span>
                <input
                  name="password_confirmation"
                  type="password"
                  {{ $user->exists ? '' : 'required' }}
                  autocomplete="new-password"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
              </label>
            </div>
          </article>

          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Access</h2>
            <div class="grid gap-5 md:grid-cols-2">
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">Role <span class="text-danger-500">*</span></span>
                <select
                  name="role_id"
                  required
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
                >
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                      {{ $role->name }}
                    </option>
                  @endforeach
                </select>
                @error('role_id')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <div class="mt-6 rounded-card border border-surface-line bg-surface-body p-4 md:mt-1.5 md:self-start">
                <label class="flex items-start gap-3">
                  <input
                    type="checkbox"
                    name="status"
                    value="1"
                    {{ old('status', $user->status ?? true) ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 rounded border-surface-line text-brand-600 focus:ring-brand-600"
                  />
                  <span>
                    <span class="block text-[14px] font-semibold text-ink-900">Active</span>
                    <span class="mt-1 block text-[13px] text-ink-500">Inactive users cannot sign in to the dashboard.</span>
                  </span>
                </label>
              </div>
            </div>
          </article>
        </form>

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-surface-line pt-5">
          <a
            href="{{ route('app.users.index') }}"
            class="inline-flex h-11 items-center rounded-base border border-surface-line px-5 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
            >Cancel</a
          >
          <button
            type="submit"
            form="user-form"
            class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
          >
            <i data-lucide="save" class="h-4 w-4"></i>
            {{ $user->exists ? 'Update User' : 'Save User' }}
          </button>
        </div>
      @endsection
