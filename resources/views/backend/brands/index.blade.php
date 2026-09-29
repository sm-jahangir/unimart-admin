@extends('layouts.backend.app')

@section('title', 'Brands')

@section('page', 'brands')

@section('content')
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Catalog</p>
            <h1 class="text-[24px] font-semibold text-ink-900">Brands</h1>
            <p class="mt-1 text-[14px] text-ink-500">
              Manage product brands, storefront visibility, and brand merchandising details.
            </p>
          </div>
          @can('app.brands.create')
            <a
              href="{{ route('app.brands.create') }}"
              class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-4 text-[14px] font-semibold text-white hover:bg-brand-700"
            >
              <i data-lucide="plus" class="h-4 w-4"></i>
              Add Brand
            </a>
          @endcan
        </div>

        <section class="grid gap-6 md:grid-cols-3">
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-brand-500 pl-3">
                <p class="text-[15px] text-ink-400">Total Brands</p>
                <strong class="mt-1 block text-[28px] font-semibold leading-none text-ink-700">{{ $stats['total'] }}</strong>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-brand-50 text-brand-600">
                <i data-lucide="store" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-admin-teal pl-3">
                <p class="text-[15px] text-ink-400">Published</p>
                <strong class="mt-1 block text-[28px] font-semibold leading-none text-ink-700">{{ $stats['published'] }}</strong>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-success-50 text-admin-teal">
                <i data-lucide="check" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
          <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
            <div class="flex items-center justify-between gap-4">
              <div class="border-l-2 border-danger-500 pl-3">
                <p class="text-[15px] text-ink-400">Featured</p>
                <strong class="mt-1 block text-[28px] font-semibold leading-none text-ink-700">{{ $stats['featured'] }}</strong>
              </div>
              <div class="grid h-11 w-11 place-items-center rounded-base bg-brand-50 text-brand-600">
                <i data-lucide="star" class="h-5 w-5"></i>
              </div>
            </div>
          </article>
        </section>

        <section
          data-list-table
          data-list-noun="brands"
          class="mt-6 rounded-card border border-surface-line bg-surface-card p-6 shadow-card"
        >
          <div class="mb-5 flex flex-wrap items-center gap-3">
            <label class="relative block min-w-[220px] flex-1">
              <span class="sr-only">Search brands</span>
              <i
                data-lucide="search"
                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400"
              ></i>
              <input
                data-list-search
                type="search"
                placeholder="Search brands"
                class="h-11 w-full rounded-base border border-surface-line bg-surface-body pl-11 pr-4 text-[14px] focus:border-brand-600"
              />
            </label>
          </div>

          <div class="dashboard-scrollbar overflow-x-auto">
            <table class="w-full min-w-[900px] text-left">
              <thead>
                <tr class="border-b border-surface-line text-[13px] uppercase text-ink-400">
                  <th class="pb-3 pr-4 font-semibold">
                    <button type="button" data-sort="name" class="inline-flex items-center gap-1 uppercase hover:text-ink-700">
                      Brand <i data-lucide="chevron-down" class="h-3.5 w-3.5"></i>
                    </button>
                  </th>
                  <th class="pb-3 pr-4 font-semibold">Slug</th>
                  <th class="pb-3 pr-4 font-semibold">Website</th>
                  <th class="pb-3 pr-4 font-semibold">Featured</th>
                  <th class="pb-3 pr-4 font-semibold">Status</th>
                  <th class="pb-3 text-right font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="text-[14px]">
                @forelse ($brands as $brand)
                  <tr data-name="{{ $brand->name }}" class="border-b border-surface-line hover:bg-surface-body/70">
                    <td class="py-4 pr-4">
                      <div class="flex items-center gap-3">
                        @if ($brand->logo)
                          <img src="{{ $brand->logoUrl() }}" alt="{{ $brand->name }}" class="grid h-12 w-12 shrink-0 place-items-center rounded-base object-cover" />
                        @else
                          <span class="grid h-12 w-12 shrink-0 place-items-center rounded-base bg-brand-50 text-brand-600 text-[14px] font-semibold">
                            {{ $brand->initials() }}
                          </span>
                        @endif
                        <div class="min-w-0">
                          @can('app.brands.edit')
                            <a href="{{ route('app.brands.edit', $brand) }}" class="block truncate font-semibold text-ink-900 hover:text-brand-600">{{ $brand->name }}</a>
                          @else
                            <span class="block truncate font-semibold text-ink-900">{{ $brand->name }}</span>
                          @endcan
                          @if ($brand->support_email)
                            <span class="block truncate text-[12px] text-ink-400">{{ $brand->support_email }}</span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td class="py-4 pr-4 text-ink-500">{{ $brand->slug }}</td>
                    <td class="py-4 pr-4 text-ink-700">
                      @if ($brand->website)
                        <a href="{{ $brand->website }}" target="_blank" rel="noopener" class="text-brand-600 hover:text-brand-700">{{ $brand->website }}</a>
                      @else
                        <span class="text-ink-400">—</span>
                      @endif
                    </td>
                    <td class="py-4 pr-4 text-ink-700">{{ $brand->featured ? 'Featured' : '—' }}</td>
                    <td class="py-4 pr-4">
                      <span class="badge {{ $brand->status === 'published' ? 'bg-success-50 text-success-600' : 'bg-surface-muted text-ink-600' }}">
                        {{ ucfirst($brand->status) }}
                      </span>
                    </td>
                    <td class="py-4 text-right">
                      <div class="inline-flex items-center gap-1">
                        @can('app.brands.edit')
                          <a href="{{ route('app.brands.edit', $brand) }}" class="icon-button hover:bg-brand-50 hover:text-brand-600" aria-label="Edit {{ $brand->name }}">
                            <i data-lucide="pencil" class="h-4 w-4"></i>
                          </a>
                        @endcan
                        @can('app.brands.destroy')
                          <form method="POST" action="{{ route('app.brands.destroy', $brand) }}" class="inline"
                                onsubmit="return confirm('This will permanently remove the {{ $brand->name }} brand. Continue?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button hover:bg-danger-50 hover:text-danger-500" aria-label="Delete {{ $brand->name }}">
                              <i data-lucide="trash-2" class="h-4 w-4"></i>
                            </button>
                          </form>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="py-10 text-center text-[14px] text-ink-400">No brands found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <p data-list-empty class="hidden py-10 text-center text-[14px] text-ink-400">No brands match your search.</p>

          <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-surface-line pt-4">
            <p class="text-[13px] text-ink-500">
              Showing {{ $brands->firstItem() }}–{{ $brands->lastItem() }} of {{ $brands->total() }} brands
            </p>
            <div class="flex items-center gap-2">
              <a
                href="{{ $brands->previousPageUrl() }}"
                class="inline-flex h-10 items-center rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $brands->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}"
              >Prev</a>
              <a
                href="{{ $brands->nextPageUrl() }}"
                class="inline-flex h-10 items-center gap-1 rounded-base border border-surface-line px-3 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted {{ $brands->hasMorePages() ? '' : 'pointer-events-none opacity-40' }}"
              >Next <i data-lucide="chevron-right" class="h-4 w-4"></i></a>
            </div>
          </div>
        </section>
      @endsection
