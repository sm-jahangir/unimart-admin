@extends('layouts.backend.app')

@section('title', 'Roles')

@section('page', 'roles')

@section('content')
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Access Control</p>
            <h1 class="text-[24px] font-semibold text-ink-900">Roles</h1>
            <p class="mt-1 text-[14px] text-ink-500">Control dashboard permissions for admins and staff members.</p>
          </div>
          @can('app.roles.create')
            <a
              href="{{ route('app.roles.create') }}"
              class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-4 text-[14px] font-semibold text-white hover:bg-brand-700"
            >
              <i data-lucide="plus" class="h-4 w-4"></i>
              Create Role
            </a>
          @endcan
        </div>

        <section
          data-list-table
          data-list-noun="roles"
          class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
        >
          <div class="mb-5 flex flex-wrap items-center gap-3">
            <label class="relative block min-w-[220px] flex-1">
              <span class="sr-only">Search roles</span>
              <i
                data-lucide="search"
                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400"
              ></i>
              <input
                data-list-search
                type="search"
                placeholder="Search roles"
                class="h-11 w-full rounded-base border border-surface-line bg-surface-body pl-11 pr-4 text-[14px] focus:border-brand-600"
              />
            </label>
          </div>

          <div class="dashboard-scrollbar overflow-x-auto">
            <table class="w-full min-w-[820px] text-left">
              <thead>
                <tr class="border-b border-surface-line text-[13px] uppercase text-ink-400">
                  <th class="pb-3 pr-4 font-semibold">
                    <button type="button" data-sort="name" class="inline-flex items-center gap-1 uppercase hover:text-ink-700">
                      Role <i data-lucide="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>
                  </th>
                  <th class="pb-3 pr-4 font-semibold">Users</th>
                  <th class="pb-3 pr-4 font-semibold">Permissions</th>
                  <th class="pb-3 pr-4 font-semibold">Type</th>
                  <th class="pb-3 text-right font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="text-[14px]">
                @forelse ($roles as $role)
                  <tr data-name="{{ $role->name }}" class="border-b border-surface-line hover:bg-surface-body/70">
                    <td class="py-4 pr-4 font-semibold text-ink-900">
                      {{ $role->name }}
                      @if ($role->description)
                        <span class="block text-[12px] font-normal text-ink-500">{{ $role->description }}</span>
                      @endif
                    </td>
                    <td class="py-4 pr-4 text-ink-700">{{ $role->users_count }} users</td>
                    <td class="py-4 pr-4 text-ink-500">{{ $role->permissions_count }}</td>
                    <td class="py-4 pr-4">
                      <span class="badge {{ $role->deletable ? 'bg-success-50 text-success-600' : 'bg-surface-muted text-ink-600' }}">
                        {{ $role->deletable ? 'Custom' : 'System' }}
                      </span>
                    </td>
                    <td class="py-4 text-right">
                      @can('app.roles.edit')
                        <a
                          href="{{ route('app.roles.edit', $role) }}"
                          class="icon-button hover:bg-brand-50 hover:text-brand-600"
                          aria-label="Edit {{ $role->name }}"
                          ><i data-lucide="pencil" class="h-4 w-4"></i
                        ></a>
                      @endcan
                      @can('app.roles.destroy')
                        @if ($role->deletable)
                          <form method="POST" action="{{ route('app.roles.destroy', $role) }}" class="inline"
                                onsubmit="return confirm('Delete this role?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button hover:bg-danger-50 hover:text-danger-600" aria-label="Delete {{ $role->name }}">
                              <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                          </form>
                        @endif
                      @endcan
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="py-10 text-center text-[14px] text-ink-400">No roles found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <p data-list-empty class="hidden py-10 text-center text-[14px] text-ink-400">No roles match your search.</p>

          <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-surface-line pt-4">
            <p class="text-[13px] text-ink-500" data-list-info>Showing {{ $roles->count() }} of {{ $roles->count() }} roles</p>
          </div>
        </section>
      @endsection
