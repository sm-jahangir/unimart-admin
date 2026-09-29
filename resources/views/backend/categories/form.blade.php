@extends('layouts.backend.app')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('page', 'categories')

@push('modals')
    {{-- Form Guide drawer (template design) --}}
    <div data-drawer="form-guide" class="fixed inset-0 z-50 hidden justify-end" role="dialog" aria-modal="true">
      <div data-drawer-backdrop class="absolute inset-0 bg-ink-900/45 opacity-0 transition-opacity duration-200"></div>
      <aside
        data-drawer-panel
        class="relative ml-auto flex h-full w-full max-w-md translate-x-full flex-col bg-surface-card shadow-lift transition-transform duration-200"
      >
        <div class="flex items-start justify-between gap-4 border-b border-surface-line px-5 py-4">
          <div>
            <p class="text-[12px] font-semibold uppercase tracking-wide text-brand-600">Form Guide</p>
            <h2 class="mt-1 text-[18px] font-semibold text-ink-900">Compact editing checklist</h2>
            <p class="mt-1 text-[13px] text-ink-500">Use the tabs to finish only the section you are working on.</p>
          </div>
          <button
            type="button"
            data-drawer-close
            class="grid h-9 w-9 shrink-0 place-items-center rounded-base border border-surface-line text-ink-500 hover:bg-surface-muted hover:text-ink-900"
            aria-label="Close form guide"
          >
            <i data-lucide="x" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-5">
          <div class="space-y-4">
            <section class="rounded-base border border-surface-line p-4">
              <h3 class="text-[14px] font-semibold text-ink-900">Before publishing</h3>
              <ul class="mt-3 space-y-2 text-[13px] text-ink-500">
                <li class="flex gap-2">
                  <i data-lucide="check" class="mt-0.5 h-4 w-4 text-success-500"></i>Category name and parent are set.
                </li>
                <li class="flex gap-2">
                  <i data-lucide="check" class="mt-0.5 h-4 w-4 text-success-500"></i>Thumbnail image matches the final
                  storefront content.
                </li>
                <li class="flex gap-2">
                  <i data-lucide="check" class="mt-0.5 h-4 w-4 text-success-500"></i>SEO tab is reviewed before saving.
                </li>
              </ul>
            </section>

            <section class="rounded-base border border-surface-line p-4">
              <h3 class="text-[14px] font-semibold text-ink-900">Fast layout tips</h3>
              <p class="mt-2 text-[13px] leading-6 text-ink-500">
                The main form groups related fields into tabs and tighter rows. Sidebar cards keep thumbnail, status,
                and template controls close without taking over the page.
              </p>
            </section>

            <section class="rounded-base border border-surface-line p-4">
              <h3 class="text-[14px] font-semibold text-ink-900">Common saves</h3>
              <div class="mt-3 grid grid-cols-2 gap-2 text-[12px] font-semibold text-ink-600">
                <span class="rounded-base bg-surface-muted px-3 py-2">Draft first</span>
                <span class="rounded-base bg-surface-muted px-3 py-2">Check preview</span>
                <span class="rounded-base bg-surface-muted px-3 py-2">Review SEO</span>
                <span class="rounded-base bg-surface-muted px-3 py-2">Save changes</span>
              </div>
            </section>
          </div>
        </div>
      </aside>
    </div>

    {{-- Tabs, thumbnail preview and drawer behaviour (page bundle replaced by this) --}}
    <script>
      (function () {
        var form = document.getElementById('category-form');

        // Tabs
        form.querySelectorAll('[data-form-tab]').forEach(function (tab) {
          tab.addEventListener('click', function () {
            form.querySelectorAll('[data-form-tab]').forEach(function (t) {
              var active = t === tab;
              t.setAttribute('aria-selected', active);
              t.classList.toggle('border-brand-600', active);
              t.classList.toggle('text-brand-600', active);
              t.classList.toggle('border-surface-line', !active);
              t.classList.toggle('text-ink-500', !active);
            });
            form.querySelectorAll('[data-form-panel]').forEach(function (panel) {
              panel.classList.toggle('hidden', panel.dataset.formPanel !== tab.dataset.formTab);
            });
          });
        });
        form.querySelector('[data-form-tab]')?.click();

        // Thumbnail preview
        var input = form.querySelector('#thumb-input');
        var preview = form.querySelector('#thumb-preview');
        var fallback = form.querySelector('#thumb-fallback');
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

        // Drawer
        var drawer = document.querySelector('[data-drawer="form-guide"]');
        var openDrawer = function (open) {
          drawer.classList.toggle('flex', open);
          drawer.classList.toggle('hidden', !open);
          var panel = drawer.querySelector('[data-drawer-panel]');
          requestAnimationFrame(function () {
            panel.classList.toggle('!translate-x-0', open);
          });
        };
        document.querySelector('[data-drawer-open="form-guide"]')?.addEventListener('click', function () { openDrawer(true); });
        drawer.querySelector('[data-drawer-close]')?.addEventListener('click', function () { openDrawer(false); });
        drawer.querySelector('[data-drawer-backdrop]')?.addEventListener('click', function () { openDrawer(false); });
      })();
    </script>
@endpush

@section('content')
        <!-- Page header -->
        <div class="add-category-page-header mb-5 flex flex-wrap items-center justify-between gap-3">
          <div class="min-w-0 max-w-full">
            <nav class="mb-1 flex items-center gap-1.5 text-[13px] text-ink-400">
              <a href="{{ route('app.dashboard') }}" class="hover:text-brand-600">Home</a>
              <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
              <a href="{{ route('app.categories.index') }}" class="hover:text-brand-600">Catalog</a>
              <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
              <span class="text-ink-700">{{ $category->exists ? 'Edit Category' : 'Add Category' }}</span>
            </nav>
            <h1 class="text-[22px] font-semibold text-ink-900">{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h1>
            <p class="mt-1 break-words text-[14px] text-ink-500">
              Create a merchandising group with thumbnail, SEO meta, and product assignment rules.
            </p>
          </div>
          <button
            type="button"
            data-drawer-open="form-guide"
            class="inline-flex h-10 items-center gap-2 rounded-base border border-surface-line px-4 text-[13px] font-semibold text-ink-700 hover:bg-surface-muted"
          >
            <i data-lucide="list-tree" class="h-4 w-4"></i>
            Form Guide
          </button>
        </div>

        @if ($errors->any())
          <div class="mb-5 rounded-base border border-danger-600/30 bg-danger-50 px-4 py-3 text-[13px] text-danger-600">
            <ul class="list-inside list-disc space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form
          id="category-form"
          action="{{ $category->exists ? route('app.categories.update', $category) : route('app.categories.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid min-w-0 max-w-full gap-4 xl:grid-cols-[280px_minmax(0,1fr)]"
        >
          @csrf
          @if ($category->exists)
            @method('PUT')
          @endif

          <!-- ── Side panels ── -->
          <div class="min-w-0 space-y-4 xl:order-1">
            <!-- Thumbnail -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <h2 class="mb-3 text-[15px] font-semibold text-ink-900">Thumbnail</h2>
              <div class="flex flex-col items-center text-center">
                <label
                  data-thumb-zone
                  class="group relative grid h-36 w-36 cursor-pointer place-items-center overflow-hidden rounded-base bg-surface-card shadow-soft transition-shadow hover:shadow-lift"
                >
                  <span
                    class="absolute right-2 top-2 z-10 grid h-7 w-7 place-items-center rounded-full bg-surface-card text-ink-400 shadow-card transition-colors group-hover:text-brand-600"
                  >
                    <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                  </span>
                  <span id="thumb-fallback" class="grid h-20 w-20 -rotate-6 place-items-center rounded-base bg-brand-50 text-brand-200 {{ $category->image ? 'hidden' : '' }}">
                    <i data-lucide="image" class="h-10 w-10 transition-colors group-hover:text-brand-400"></i>
                  </span>
                  <img
                    id="thumb-preview"
                    src="{{ $category->image ? $category->imageUrl() : '#' }}"
                    alt="Thumbnail preview"
                    class="absolute inset-0 h-full w-full object-contain p-2 {{ $category->image ? '' : 'hidden' }}"
                  />
                  <input type="file" accept=".png,.jpg,.jpeg" aria-label="Upload thumbnail image" class="sr-only" id="thumb-input" name="image" />
                </label>
                <p class="mt-4 text-[12px] text-ink-400">
                  Set the category thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted.
                </p>
                @error('image')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
              </div>
            </article>

            <!-- Status -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <div class="mb-3 flex items-center justify-between">
                <h2 class="text-[15px] font-semibold text-ink-900">Status</h2>
                <span id="status-dot" class="h-2.5 w-2.5 rounded-full {{ ($category->status ?? 'published') === 'published' ? 'bg-success-500' : 'bg-ink-400' }}"></span>
              </div>
              <select
                name="status"
                id="status-select"
                class="h-10 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
              >
                <option value="published" {{ old('status', $category->status ?? 'published') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ old('status', $category->status ?? 'published') === 'draft' ? 'selected' : '' }}>Draft</option>
              </select>
              <p class="mt-2 text-[12px] text-ink-400">Set the category status.</p>
              @error('status')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
            </article>

            <!-- Store Template -->
            <article class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card">
              <h2 class="mb-3 text-[15px] font-semibold text-ink-900">Store Template</h2>
              <label class="mb-1 block text-[13px] font-semibold text-ink-700">Select a store template</label>
              <select
                name="template"
                class="h-10 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
              >
                <option>Default template</option>
                <option>Featured template</option>
                <option>Compact template</option>
              </select>
              <p class="mt-2 text-[12px] text-ink-400">
                Assign a template from your current theme to define how the category products are displayed.
              </p>
            </article>
          </div>
          <!-- /side panels -->

          <!-- ── Main content ── -->
          <div data-form-tabs class="min-w-0 space-y-4 xl:order-2">
            <div class="flex flex-wrap gap-2" role="tablist" aria-label="Category form sections">
              <button
                type="button"
                role="tab"
                aria-selected="true"
                data-form-tab="general"
                class="inline-flex h-9 items-center rounded-base border px-4 text-[13px] font-semibold"
              >
                General
              </button>
              <button
                type="button"
                role="tab"
                aria-selected="false"
                data-form-tab="seo"
                class="inline-flex h-9 items-center rounded-base border px-4 text-[13px] font-semibold"
              >
                SEO
              </button>
            </div>

            <!-- General -->
            <article
              data-form-panel="general"
              class="rounded-card border border-surface-line bg-surface-card p-5 shadow-card"
            >
              <h2 class="mb-4 text-[16px] font-semibold text-ink-900">General</h2>
              <div class="space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                  <label class="block">
                    <span class="text-[13px] font-semibold text-ink-700"
                      >Category Name <span class="text-danger-500">*</span></span
                    >
                    <input
                      required
                      name="name"
                      value="{{ old('name', $category->name) }}"
                      placeholder="Category name"
                      class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] placeholder:text-ink-400 focus:border-brand-600"
                    />
                    <p class="mt-1 text-[12px] text-ink-400">A category name is required and recommended to be unique.</p>
                    @error('name')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                  </label>

                  <label class="block">
                    <span class="text-[13px] font-semibold text-ink-700">Parent Category</span>
                    <select
                      name="parent_id"
                      class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-card px-3 text-[14px] text-ink-700 focus:border-brand-600"
                    >
                      <option value="">— None (top level) —</option>
                      @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                          {{ $parent->indentedName() }}
                        </option>
                      @endforeach
                    </select>
                    <p class="mt-1 text-[12px] text-ink-400">Nested categories appear under their parent in storefront navigation.</p>
                    @error('parent_id')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                  </label>

                  <label class="block">
                    <span class="text-[13px] font-semibold text-ink-700">Slug</span>
                    <input
                      name="slug"
                      value="{{ old('slug', $category->slug) }}"
                      placeholder="auto-generated from name"
                      class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] placeholder:text-ink-400 focus:border-brand-600"
                    />
                    <p class="mt-1 text-[12px] text-ink-400">Leave empty to generate the slug from the category name.</p>
                    @error('slug')<p class="mt-1 text-[12px] text-danger-600">{{ $message }}</p>@enderror
                  </label>

                  <label class="block">
                    <span class="text-[13px] font-semibold text-ink-700">Sort Order</span>
                    <input
                      name="sort_order"
                      type="number"
                      min="0"
                      value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                      class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                    />
                    <p class="mt-1 text-[12px] text-ink-400">Lower numbers appear first in navigation.</p>
                  </label>
                </div>

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
                      rows="3"
                      placeholder="Type your text here..."
                      class="min-h-[132px] w-full resize-y bg-transparent px-3 py-3 text-[14px] text-ink-700 placeholder:text-ink-400 focus:outline-none"
                    >{{ old('description', $category->description) }}</textarea>
                  </div>
                  <p class="mt-1 text-[12px] text-ink-400">Set a description to the category for better visibility.</p>
                </div>
              </div>
            </article>

            <!-- Meta Options -->
            <article
              data-form-panel="seo"
              class="hidden rounded-card border border-surface-line bg-surface-card p-5 shadow-card"
            >
              <h2 class="mb-4 text-[16px] font-semibold text-ink-900">Meta Options</h2>
              <div class="space-y-4">
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Title</span>
                  <input
                    type="text"
                    name="meta_title"
                    value="{{ old('meta_title', $category->meta_title) }}"
                    placeholder="Meta tag name"
                    class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">
                    Set a meta tag title. Recommended to be simple and precise keywords.
                  </p>
                </label>
                <div>
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Description</span>
                  <div class="mt-1.5 rounded-base border border-surface-line bg-surface-body">
                    <div class="flex flex-wrap items-center gap-1 border-b border-surface-line px-3 py-2">
                      <select class="h-7 rounded border-0 bg-transparent py-0 text-[12px] text-ink-600 focus:ring-0">
                        <option>Normal</option>
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
                      name="meta_desc"
                      rows="3"
                      placeholder="Type your text here..."
                      class="min-h-[88px] w-full resize-y bg-transparent px-3 py-3 text-[14px] text-ink-700 placeholder:text-ink-400 focus:outline-none"
                    >{{ old('meta_desc', $category->meta_desc) }}</textarea>
                  </div>
                  <p class="mt-1 text-[12px] text-ink-400">
                    Set a meta tag description to the category for increased SEO ranking.
                  </p>
                </div>
                <label class="block">
                  <span class="text-[13px] font-semibold text-ink-700">Meta Tag Keywords</span>
                  <input
                    type="text"
                    name="meta_keywords"
                    value="{{ old('meta_keywords', $category->meta_keywords) }}"
                    placeholder="e.g. grocery, fresh, organic"
                    class="mt-1.5 h-10 w-full rounded-base border border-surface-line bg-surface-body px-3 text-[14px] focus:border-brand-600"
                  />
                  <p class="mt-1 text-[12px] text-ink-400">
                    Set a list of keywords that the category is related to. Separate the keywords by adding a comma
                    between each keyword.
                  </p>
                </label>
              </div>
            </article>
          </div>
          <!-- /main -->
        </form>

        <!-- Bottom action bar -->
        <div class="mt-6 flex items-center justify-end gap-3 border-t border-surface-line pt-5">
          <a
            href="{{ route('app.categories.index') }}"
            class="inline-flex h-10 items-center gap-2 rounded-base border border-surface-line px-5 text-[14px] font-semibold text-ink-700 hover:bg-surface-muted"
            >Cancel</a
          >
          <button
            type="submit"
            form="category-form"
            class="inline-flex h-10 items-center gap-2 rounded-base bg-brand-600 px-5 text-[14px] font-semibold text-white hover:bg-brand-700"
          >
            <i data-lucide="save" class="h-4 w-4"></i>
            {{ $category->exists ? 'Update Category' : 'Save Changes' }}
          </button>
        </div>
      @endsection
