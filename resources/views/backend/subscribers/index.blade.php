@extends('layouts.backend.app')

@section('title', 'Subscribers')

@section('page', 'subscribers')

@section('content')
        <div class="mb-6">
          <p class="mb-1 text-[13px] font-semibold uppercase text-brand-600">Marketing</p>
          <h1 class="text-[24px] font-semibold text-ink-900">Subscribers</h1>
          <p class="mt-1 text-[14px] text-ink-500"></p>
        </div>
        <section class="rounded-card border border-surface-line bg-surface-card p-6 shadow-card">
          <div class="dashboard-scrollbar overflow-x-auto">
            <table class="w-full text-left text-[14px]">
              <thead>
                <tr class="border-b border-surface-line text-[13px] uppercase text-ink-400"></tr>
              </thead>
              <tbody>
                @forelse ($subscribers as $item)
                  <tr class="border-b border-surface-line">

                  </tr>
                @empty
                  <tr><td colspan="9" class="py-10 text-center text-[14px] text-ink-400">No records found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>
      @endsection
