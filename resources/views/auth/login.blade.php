@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-lg rounded-2xl bg-white p-8 shadow-sm">
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Login</h2>
            <p class="mt-1 text-sm text-slate-500">Use your email and password to sign in.</p>
        </header>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="post" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf

            <label class="block text-sm font-medium text-slate-700">
                Email
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <span class="mt-1 block text-xs text-red-600">@error('email'){{ $message }}@enderror</span>
            </label>

            <label class="block text-sm font-medium text-slate-700">
                Password
                <input type="password" name="password" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <span class="mt-1 block text-xs text-red-600">@error('password'){{ $message }}@enderror</span>
            </label>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Remember me
            </label>

            <div class="flex items-center gap-3">
                <button class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" type="submit">
                    Login
                </button>
            </div>
        </form>
    </section>
@endsection

