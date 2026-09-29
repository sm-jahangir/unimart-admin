@extends('layouts.backend.app')

@section('title', $brand->exists ? 'Edit Brand' : 'Add Brand')

@section('page', 'brands')

@push('modals')
    {{-- Logo preview and status dot behaviour (page bundle replaced by this) --}}
    <script>
      (function () {
        var form = document.getElementById('brand-form');

        // Logo preview
        var input = form.querySelector('#logo-input');
        var preview = form.querySelector('#logo-preview');
        var fallback = form.querySelector('#logo-fallback');
        input?.addEventListener('change', function () {
          if (input.files?.[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
            fallback?.classList.add('hidden');
          }
        });

        // Status dot
        var status = form.querySelector('#status-select');
        var dot = form.querySelector('#status-dot');
        var syncDot = function () {
          dot?.classList.toggle('bg-success-500', status.value === 'published');
          dot?.classList.toggle('bg-ink-400', status.value !== 'published');
        };
        status?.addEventListener('change', syncDot);
        syncDot();
      })();
    </script>
@endpush

@section('content')
        <!-- Page header -->
        <div class="add-brand-page-header mb-6 flex flex-wrap items-center justify-between gap-3">
          <div class="min-w-0 max-w-full">
            <nav class="mb-1 flex items-center gap-1.5 text-[13px] text-ink-400">
              <a href="{{ route('app.dashboard') }}" class="hover:text-brand-600">Home</a>
              <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
              <a href="{{ route('app.brands.index') }}" class="hover:text-brand-600">Catalog</a>
              <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
              <span class="text-ink-700">{{ $brand->exists ? 'Edit Brand' : 'Add Brand' }}</span>
            </nav>
            <h1 class="text-[22px] font-semibold text-ink-900">{{ $brand->exists ? 'Edit Brand' : 'Add Brand' }}</h1>
            <p class="mt-1 break-words text-[14px] text-ink-500">
              Create a brand profile with logo, storefront visibility, SEO meta, and product assignment rules.
            </p>
          </div>
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
          id="brand-form"
          action="{{ $brand->exists ? route('app.brands.update', $brand) : route('app.brands.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid min-w-0 max-w-full gap-6 xl:grid-cols-[280px_minmax(0,1fr)]"
        >
          @csrf
          @if ($brand->exists)
            @method('PUT')
          @endif

          <!-- ── Side panels ── -->
          <div class="min-w-0 space-y-6 xl:order-1">
            <!-- Brand Logo -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <h2 class="mb-3 text-[15px] font-semibold text-ink-900">Brand Logo</h2>
              <div class="flex flex-col items-center text-center">
                <label
                  data-logo-zone
                  class="group relative grid h-36 w-36 cursor-pointer place-items-center overflow-hidden rounded-base bg-surface-card shadow-soft transition-shadow hover:shadow-lift"
                >
                  <span
                    class="absolute right-2 top-2 z-10 grid h-7 w-7 place-items-center rounded-full bg-surface-card text-ink-400 shadow-card transition-colors group-hover:text-brand-600"
                  >
                    <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                  </span>
                  <span id="logo-fallback" class="grid h-20 w-20 -rotate-6 place-items-center rounded-base bg-brand-50 text-brand-200 {{ $brand->logo ? 'hidden' : '' }}">
                    <i data-lucide="image" class="h-10 w-10 transition-colors group-hover:text-brand-400"></i>
                  </span>
                  <img
                    id="logo-preview"
                    src="{{ $brand->logo ? $brand->logoUrl() : '#' }}"
                    alt="Brand logo preview"
                    class="absolute inset-0 h-full w-full object-contain p-3 {{ $brand->logo ? '' : 'hidden' }}"
                  />
                  <input type="file" accept=".png,.jpg,.jpeg,.svg,.webp" aria-label="Upload brand logo" class="sr-only" id="logo-input" name="logo" />
                </label>
                <p class="mt-4 text-[12px] text-ink-400">
                  Upload a brand logo. PNG, JPG, SVG, and WEBP files are accepted.
                </p>
                @error('logo')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </div>
            </article>

            <!-- Status -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <div class="mb-3 flex items-center justify-between">
                <h2 class="text-[15px] font-semibold text-ink-900">Status</h2>
                <span id="status-dot" class="h-2.5 w-2.5 rounded-full {{ ($brand->status ?? 'published') === 'published' ? 'bg-success-500' : 'bg-ink-400' }}"></span>
              </div>
              <select
                name="status"
                id="status-select"
                class="h-11 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
              >
                <option value="published" {{ old('status', $brand->status ?? 'published') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ old('status', $brand->status ?? 'published') === 'draft' ? 'selected' : '' }}>Draft</option>
              </select>
              <p class="mt-2 text-[12px] text-ink-400">Set whether this brand is visible to shoppers.</p>
              @error('status')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
            </article>

            <!-- Storefront Placement -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <h2 class="mb-3 text-[15px] font-semibold text-ink-900">Storefront Placement</h2>
              <label class="mb-1 block text-[13px] font-semibold text-ink-700">Visibility</label>
              <select
                name="featured"
                class="h-11 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
              >
                <option value="1" {{ old('featured', $brand->featured ?? false) ? 'selected' : '' }}>Featured brand</option>
                <option value="0" {{ ! old('featured', $brand->featured ?? false) ? 'selected' : '' }}>Standard brand</option>
              </select>
              <p class="mt-2 text-[12px] text-ink-400">
                Featured brands can be promoted in storefront brand collections and product filters.
              </p>
            </article>

            <!-- Brand Links -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <h2 class="mb-3 text-[15px] font-semibold text-ink-900">Brand Links</h2>
              <label class="block">
                <span class="text-[13px] font-semibold text-ink-700">Website</span>
                <input
                  type="url"
                  name="website"
                  value="{{ old('website', $brand->website) }}"
                  placeholder="https://brand.com/"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
                @error('website')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
              <label class="mt-4 block">
                <span class="text-[13px] font-semibold text-ink-700">Support Email</span>
                <input
                  type="email"
                  name="support_email"
                  value="{{ old('support_email', $brand->support_email) }}"
                  placeholder="support@brand.com"
                  class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                />
                @error('support_email')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </label>
            </article>
          </div>
          <!-- /side panels -->

          <!-- ── Main content ── -->
          <div class="min-w-0 space-y-6 xl:order-2">
            <!-- General -->
            <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
              <h2 class="mb-5 text-[17px] font-semibold text-ink-900">General</h2>
              <div class="space-y-5">
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700"
                    >Brand Name <span class="text-danger-500">*</span></span
                  >
                  <input
                    required
                    name="name"
                    value="{{ old('name', $brand->name) }}"
                    placeholder="Brand name"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] placeholder:text-ink-400 focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">A brand name is required and should be unique.</p>
                  @error('name')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                </label>

                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Slug</span>
                  <input
                    name="slug"
                    value="{{ old('slug', $brand->slug) }}"
                    placeholder="brand-slug"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] placeholder:text-ink-400 focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">Used in brand URLs and storefront filters. Leave empty to auto-generate.</p>
                  @error('slug')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                </label>

                <div>
                  <span class="text-[13px] font-semibold text-ink-700">Description</span>
                  <!-- Minimal rich-text toolbar (cosmetic only for template) -->
                  <div class="mt-1.5 rounded-base border border-surface-line bg-surface-body">
                    <div class="flex flex-wrap items-center gap-1 border-b border-surface-line px-3 py-2">
                      <select class="h-7 rounded border-0 bg-transparent py-0 text-[12px] text-ink-600 focus:ring-0">
                        <option>Normal</option>
                        <option>Heading 1</option>
                        <option>Heading 2</option>
                      </select>
                      <div class="mx-1 h-5 w-px bg-surface-line"></div>
                      <button
                        type="button"
                        class="rounded px-2 py-1 text-[13px] font-bold text-ink-600 hover:bg-surface-muted"
                      >
                        B
                      </button>
                      <button
                        type="button"
                        class="rounded px-2 py-1 text-[13px] italic text-ink-600 hover:bg-surface-muted"
                      >
                        I
                      </button>
                      <button
                        type="button"
                        class="rounded px-2 py-1 text-[13px] text-ink-600 underline hover:bg-surface-muted"
                      >
                        U
                      </button>
                      <div class="mx-1 h-5 w-px bg-surface-line"></div>
                      <button type="button" aria-label="Insert image" class="rounded px-2 py-1 hover:bg-surface-muted">
                        <i data-lucide="image" class="h-3.5 w-3.5 text-ink-600"></i>
                      </button>
                      <button type="button" aria-label="Insert code snippet" class="rounded px-2 py-1 hover:bg-surface-muted">
                        <i data-lucide="code" class="h-3.5 w-3.5 text-ink-600"></i>
                      </button>
                    </div>
                    <textarea
                      name="description"
                      rows="5"
                      placeholder="Type your text here..."
                      class="min-h-[190px] w-full resize-y bg-transparent px-3 py-3 text-[14px] text-ink-700 placeholder:text-ink-400 focus:outline-none"
                    >{{ old('description', $brand->description) }}</textarea>
                  </div>
                  <p class="mt-1 text-[12px] text-ink-400">
                    Add a short brand story for product detail pages and brand landing pages.
                  </p>
                </div>
              </div>
            </article>

            <!-- Brand Details -->
            <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
              <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Brand Details</h2>
              <div class="grid gap-5 md:grid-cols-2">
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Vendor Code</span>
                  <input
                    name="vendor_code"
                    value="{{ old('vendor_code', $brand->vendor_code) }}"
                    placeholder="BR-001"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                </label>
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Country or Region</span>
                  <select
                    name="country"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
                  >
                    @foreach (['Bangladesh', 'United States', 'United Kingdom', 'Germany', 'China'] as $country)
                      <option {{ old('country', $brand->country) === $country ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                  </select>
                </label>
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Sort Order</span>
                  <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', $brand->sort_order ?? 0) }}"
                    placeholder="0"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                </label>
              </div>
            </article>

            <!-- Meta Options -->
            <article class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
              <h2 class="mb-5 text-[17px] font-semibold text-ink-900">Meta Options</h2>
              <div class="space-y-5">
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Title</span>
                  <input
                    type="text"
                    name="meta_title"
                    value="{{ old('meta_title', $brand->meta_title) }}"
                    placeholder="Meta tag title"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">
                    Use a concise title that includes the brand name and key product category.
                  </p>
                </label>
                <div>
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Description</span>
                  <div class="mt-1.5 rounded-base border border-surface-line bg-surface-body">
                    <textarea
                      name="meta_desc"
                      rows="4"
                      placeholder="Type your text here..."
                      class="min-h-[96px] w-full resize-y bg-transparent px-3 py-3 text-[14px] text-ink-700 placeholder:text-ink-400 focus:outline-none"
                    >{{ old('meta_desc', $brand->meta_desc) }}</textarea>
                  </div>
                  <p class="mt-1 text-[12px] text-ink-400">Add a search-friendly brand summary for storefront SEO.</p>
                </div>
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Keywords</span>
                  <input
                    type="text"
                    name="meta_keywords"
                    value="{{ old('meta_keywords', $brand->meta_keywords) }}"
                    placeholder="e.g. electronics, audio, headphones"
                    class="mt-1.5 h-11 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">Separate keywords with commas.</p>
                </label>
              </div>
            </article>
          </div>
          <!-- /main content -->
        </form>

        <!-- Bottom action bar -->
        <div class="mt-8 flex items-center justify-end gap-3 border-t border-surface-line pt-5">
          <a
            href="{{ route('app.brands.index') }}"
            class="inline-flex h-11 items-center gap-2 rounded-base border border-surface-line px-5 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
            >Cancel</a
          >
          <button
            type="submit"
            form="brand-form"
            class="inline-flex h-11 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
          >
            <i data-lucide="save" class="h-4 w-4"></i>
            {{ $brand->exists ? 'Update Brand' : 'Save Changes' }}
          </button>
        </div>
      @endsection
