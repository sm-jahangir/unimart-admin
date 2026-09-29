@extends('layouts.backend.app')

@section('title', 'Users')

@section('page', 'users')

@section('content')
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Access Control</p>
            <h1 class="text-[24px] font-semibold text-ink-900">Users</h1>
            <p class="mt-1 text-[14px] text-ink-500">Manage dashboard accounts and their access.</p>
          </div>
          @can('app.users.create')
            <a
              href="{{ route('app.users.create') }}"
              class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-4 text-[14px] font-semibold text-white hover:bg-brand-700"
            >
              <i data-lucide="user-plus" class="h-4 w-4"></i>
              Add User
            </a>
          @endcan
        </div>

        <section
          data-list-table
          data-list-noun="users"
          class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
        >
          <div class="mb-5 flex flex-wrap items-center gap-3">
            <label class="relative block min-w-[220px] flex-1">
              <span class="sr-only">Search users</span>
              <i
                data-lucide="search"
                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400"
              ></i>
              <input
                data-list-search
                type="search"
                placeholder="Search users"
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
                      User <i data-lucide="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>
                  </th>
                  <th class="pb-3 pr-4 font-semibold">Role</th>
                  <th class="pb-3 pr-4 font-semibold">Status</th>
                  <th class="pb-3 text-right font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="text-[14px]">
                @forelse ($users as $user)
                  <tr data-name="{{ $user->name }}" class="border-b border-surface-line hover:bg-surface-body/70">
                    <td class="py-4 pr-4">
                      <span class="flex items-center gap-3">
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="h-9 w-9 rounded-full object-cover" />
                        <span class="min-w-0">
                          <span class="block font-semibold text-ink-900">{{ $user->name }}</span>
                          <span class="block truncate text-[12px] text-ink-400">{{ $user->email }}</span>
                        </span>
                      </span>
                    </td>
                    <td class="py-4 pr-4 text-ink-700">{{ $user->role->name }}</td>
                    <td class="py-4 pr-4">
                      @can('app.users.edit')
                        <form method="POST" action="{{ route('app.users.status', $user) }}">
                          @csrf
                          @method('PUT')
                          <button
                            type="submit"
                            class="badge {{ $user->status ? 'bg-success-50 text-success-600' : 'bg-surface-muted text-ink-600' }}"
                            title="{{ $user->status ? 'Deactivate' : 'Activate' }} this user"
                          >
                            {{ $user->status ? 'Active' : 'Inactive' }}
                          </button>
                        </form>
                      @else
                        <span class="badge {{ $user->status ? 'bg-success-50 text-success-600' : 'bg-surface-muted text-ink-600' }}">
                          {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                      @endcan
                    </td>
                    <td class="py-4 text-right">
                      @can('app.users.edit')
                        <a
                          href="{{ route('app.users.edit', $user) }}"
                          class="icon-button hover:bg-brand-50 hover:text-brand-600"
                          aria-label="Edit {{ $user->name }}"
                          ><i data-lucide="pencil" class="h-4 w-4"></i
                        ></a>
                      @endcan
                      @can('app.users.destroy')
                        @if ($user->id !== auth()->id())
                          <form method="POST" action="{{ route('app.users.destroy', $user) }}" class="inline"
                                onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button hover:bg-danger-50 hover:text-danger-600" aria-label="Delete {{ $user->name }}">
                              <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                          </form>
                        @endif
                      @endcan
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="py-10 text-center text-[14px] text-ink-400">No users found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <p data-list-empty class="hidden py-10 text-center text-[14px] text-ink-400">No users match your search.</p>

          <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-surface-line pt-4">
            <p class="text-[13px] text-ink-500">
              Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
            </p>
            <div class="flex items-center gap-2">
              <a
                href="{{ $users->previousPageUrl() }}"
                class="inline-flex h-10 items-center gap-1 rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $users->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}"
              >
                Prev
              </a>
              <a
                href="{{ $users->nextPageUrl() }}"
                class="inline-flex h-10 items-center gap-1 rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $users->hasMorePages() ? '' : 'pointer-events-none opacity-40' }}"
              >
                Next <i data-lucide="chevron-right" class="h-4 w-4"></i>
              </a>
            </div>
          </div>
        </section>
      @endsection
