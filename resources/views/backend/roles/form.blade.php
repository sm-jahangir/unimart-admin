@extends('layouts.backend.app')

@section('title', $role->exists ? 'Edit Role' : 'Create Role')

@section('page', 'roles')

@section('content')
        <div class="mb-6">
          <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Access Control</p>
          <h1 class="text-[24px] font-semibold text-ink-900">{{ $role->exists ? 'Edit Role' : 'Create Role' }}</h1>
          <p class="mt-1 text-[14px] text-ink-500">Define role details and dashboard permissions.</p>
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
          id="role-form"
          action="{{ $role->exists ? route('app.roles.update', $role) : route('app.roles.store') }}"
          method="POST"
          class="space-y-6"
        >
          @csrf
          @if ($role->exists)
            @method('PUT')
          @endif

          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Role Details</h2>
            <div class="grid gap-5 md:grid-cols-2">
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700"
                  >Role Name <span class="text-danger-500">*</span></span
                >
                <input
                  required
                  name="name"
                  value="{{ old('name', $role->name) }}"
                  placeholder="Store Manager"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
              </label>
              <label class="block md:col-span-2">
                <span class="text-[13px] font-semibold text-ink-700">Description</span>
                <textarea
                  name="description"
                  rows="4"
                  placeholder="What does this role control?"
                  class="mt-1.5 min-h-[110px] w-full resize-y rounded-base border border-surface-line bg-surface-body px-3 py-3 text-[14px] focus:border-brand-600"
                >{{ old('description', $role->description) }}</textarea>
              </label>
            </div>
          </article>

          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Permissions</h2>
            <div class="space-y-6">
              @foreach ($modules as $module)
                <fieldset>
                  <legend class="mb-3 text-[14px] font-semibold text-ink-900">{{ $module->name }}</legend>
                  <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($module->permissions as $permission)
                      <label
                        class="flex items-center gap-3 rounded-base border border-surface-line px-4 py-3 text-[14px] font-semibold text-ink-700"
                      >
                        <input
                          type="checkbox"
                          name="permissions[]"
                          value="{{ $permission->id }}"
                          {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                          class="h-4 w-4 rounded border-surface-line text-brand-600 focus:ring-brand-600"
                        />
                        {{ $permission->name }}
                      </label>
                    @endforeach
                  </div>
                </fieldset>
              @endforeach
            </div>
          </article>
        </form>

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-surface-line pt-5">
          <a
            href="{{ route('app.roles.index') }}"
            class="inline-flex h-11 items-center rounded-base border border-surface-line px-5 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
            >Cancel</a
          >
          <button
            type="submit"
            form="role-form"
            class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
          >
            <i data-lucide="save" class="h-4 w-4"></i>
            {{ $role->exists ? 'Update Role' : 'Save Role' }}
          </button>
        </div>
      @endsection
