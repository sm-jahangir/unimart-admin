@extends('layouts.backend.app')

@section('title', 'Users')

@section('page', 'users')

@section('content')
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">CRM</p>
            <h1 class="text-[24px] font-semibold text-ink-900">Users</h1>
            <p class="mt-1 text-[14px] text-ink-500">Review accounts, roles, and access health.</p>
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

        <section class="grid gap-6 md:grid-cols-3">
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-brand-500 pl-3">
                <p class="text-[15px] text-ink-400">Total Users</p>
                <div class="mt-1 flex flex-wrap items-center gap-2">
                  <strong class="text-[28px] font-semibold leading-none text-ink-700">{{ $stats['total'] }}</strong>
                  <span class="rounded-base px-2 py-1 text-[12px] font-semibold bg-brand-50 text-brand-600">accounts</span>
                </div>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-brand-50 text-brand-600">
                <i data-lucide="users" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-admin-teal pl-3">
                <p class="text-[15px] text-ink-400">Active</p>
                <div class="mt-1 flex flex-wrap items-center gap-2">
                  <strong class="text-[28px] font-semibold leading-none text-ink-700">{{ $stats['active'] }}</strong>
                  <span class="rounded-base px-2 py-1 text-[12px] font-semibold bg-success-50 text-success-600">can sign in</span>
                </div>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-success-50 text-admin-teal">
                <i data-lucide="check" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-danger-500 pl-3">
                <p class="text-[15px] text-ink-400">Inactive</p>
                <div class="mt-1 flex flex-wrap items-center gap-2">
                  <strong class="text-[28px] font-semibold leading-none text-ink-700">{{ $stats['inactive'] }}</strong>
                  <span class="rounded-base px-2 py-1 text-[12px] font-semibold bg-danger-50 text-danger-500">Review</span>
                </div>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-danger-50 text-danger-500">
                <i data-lucide="circle-alert" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
        </section>

        <section
          data-list-table
          data-list-noun="users"
          class="mt-6 rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
        >
          <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-[20px] font-medium text-ink-900">User Directory</h2>
            <div class="flex flex-wrap items-center gap-3">
              <label class="relative w-full sm:w-[260px]">
                <span class="sr-only">Search users</span>
                <i
                  data-lucide="search"
                  class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400"
                ></i>
                <input
                  data-list-search
                  class="h-11 w-full rounded-base border border-surface-line bg-surface-body pl-11 pr-4 text-[14px] focus:border-brand-600"
                  type="search"
                  placeholder="Search users"
                />
              </label>
              <select
                data-list-filter
                class="h-11 rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
              >
                <option value="all">All status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <div class="relative">
                <button
                  type="button"
                  data-menu-toggle="cols-users"
                  aria-haspopup="true"
                  aria-expanded="false"
                  class="inline-flex h-11 items-center gap-2 rounded-base border border-surface-line bg-surface-card px-4 text-[14px] font-semibold text-ink-700 transition-colors hover:bg-surface-muted"
                >
                  <i data-lucide="sliders-horizontal" class="h-4 w-4"></i>
                  Columns
                </button>
                <div
                  data-menu="cols-users"
                  class="absolute right-0 z-20 mt-2 hidden w-48 rounded-base border border-surface-line bg-surface-card p-2 shadow-card"
                >
                  <p class="px-2 py-1 text-[12px] font-semibold uppercase text-ink-400">Toggle columns</p>
                  <label class="flex items-center gap-2 rounded px-2 py-1.5 text-[14px] text-ink-700 hover:bg-surface-muted">
                    <input type="checkbox" data-col-item="3" checked aria-label="Toggle Role column" /> Role
                  </label>
                  <label class="flex items-center gap-2 rounded px-2 py-1.5 text-[14px] text-ink-700 hover:bg-surface-muted">
                    <input type="checkbox" data-col-item="4" checked aria-label="Toggle Phone column" /> Phone
                  </label>
                  <label class="flex items-center gap-2 rounded px-2 py-1.5 text-[14px] text-ink-700 hover:bg-surface-muted">
                    <input type="checkbox" data-col-item="5" checked aria-label="Toggle Joined column" /> Joined
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="dashboard-scrollbar overflow-x-auto">
            <table class="w-full min-w-[860px] text-left text-[14px]">
              <thead>
                <tr class="border-b border-surface-line text-[13px] uppercase text-ink-400">
                  <th class="pb-3 pr-4 font-semibold">
                    <button type="button" data-sort="name" class="inline-flex items-center gap-1 uppercase hover:text-ink-700">
                      User <i data-lucide="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>
                  </th>
                  <th class="pb-3 pr-4 font-semibold">Role</th>
                  <th class="pb-3 pr-4 font-semibold">Phone</th>
                  <th class="pb-3 pr-4 font-semibold">Joined</th>
                  <th class="pb-3 pr-4 font-semibold">Status</th>
                  <th class="pb-3 text-right font-semibold">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                  <tr data-name="{{ $user->name }}" data-status="{{ $user->status ? 'active' : 'inactive' }}" class="border-b border-surface-line hover:bg-surface-body/70">
                    <td class="py-4 pr-4">
                      <div class="flex items-center gap-3">
                        <img
                          src="{{ $user->avatarUrl() }}"
                          alt=""
                          class="h-11 w-11 rounded-full border border-surface-line object-cover"
                        />
                        <div>
                          <p class="font-semibold text-ink-900">{{ $user->name }}</p>
                          <p class="mt-1 text-[13px] text-ink-400">{{ $user->email }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="py-4 pr-4 text-ink-700">{{ $user->role->name }}</td>
                    <td class="py-4 pr-4 text-ink-700">{{ $user->phone ?? '—' }}</td>
                    <td class="py-4 pr-4 text-ink-700">{{ $user->created_at->format('d M Y') }}</td>
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
                      <div class="inline-flex items-center gap-1">
                        @can('app.users.edit')
                          <a href="{{ route('app.users.edit', $user) }}" class="icon-button hover:bg-brand-50 hover:text-brand-600" aria-label="Edit {{ $user->name }}">
                            <i data-lucide="pencil" class="h-4 w-4"></i>
                          </a>
                        @endcan
                        @can('app.users.destroy')
                          @if ($user->id !== auth()->id())
                            <form method="POST" action="{{ route('app.users.destroy', $user) }}" class="inline"
                                  onsubmit="return confirm('Delete this user?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="icon-button hover:bg-danger-50 hover:text-danger-500" aria-label="Delete {{ $user->name }}">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                              </button>
                            </form>
                          @endif
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="py-10 text-center text-[14px] text-ink-400">No users found.</td>
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
                class="inline-flex h-10 items-center rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $users->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}"
              >Prev</a>
              <a
                href="{{ $users->nextPageUrl() }}"
                class="inline-flex h-10 items-center gap-1 rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $users->hasMorePages() ? '' : 'pointer-events-none opacity-40' }}"
              >Next <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
            </div>
          </div>
        </section>
      @endsection
