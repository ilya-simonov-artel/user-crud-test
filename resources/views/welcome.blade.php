@extends('layouts.app')

@section('content')
    <section class="rounded-2xl bg-white p-8 shadow-sm">
        <div class="grid gap-6 lg:grid-cols-[1.2fr_1fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-600">User profile demo</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Laravel User CRUD</h1>
                <p class="mt-3 text-base text-slate-600">
                    This project demonstrates profile editing, avatar uploads, and an admin user panel built with Tailwind CSS,
                    Alpine.js, and axios.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('profile.edit', auth()->user()) }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Go to profile
                        </a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300">
                                Manage users
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Log in
                        </a>
                    @endauth
                </div>
            </div>

            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                <p class="font-semibold text-slate-900">Quick facts</p>
                <ul class="mt-3 space-y-2">
                    <li class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                        AJAX profile updates without full page reload.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                        Admin-only user management with search + pagination.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                        Avatar upload with image processing.
                    </li>
                </ul>
            </div>
        </div>
    </section>
@endsection
