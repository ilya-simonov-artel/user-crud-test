@extends('layouts.app')

@section('content')
    <section class="rounded-2xl bg-white p-8 shadow-sm">
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Profile</h2>
            <p class="mt-1 text-sm text-slate-500">Your profile details.</p>
        </header>

        <div class="mt-6 grid gap-6 rounded-2xl border border-slate-100 bg-slate-50 p-6 md:grid-cols-[140px_1fr] md:items-center">
            <img
                src="{{ $user->avatar_path ? Storage::disk('public')->url($user->avatar_path) : 'https://placehold.co/120x120' }}"
                alt="Profile avatar"
                class="h-28 w-28 rounded-2xl border border-slate-200 bg-white object-cover"
            >

            <div class="space-y-2 text-sm text-slate-700">
                <div><span class="font-semibold text-slate-900">Name:</span> {{ $user->name }}</div>
                <div><span class="font-semibold text-slate-900">Email:</span> {{ $user->email }}</div>
                <div><span class="font-semibold text-slate-900">Phone:</span> {{ $user->phone ?? '—' }}</div>
            </div>
        </div>

        <div class="mt-6">
            <a class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" href="{{ route('profile.edit', $user) }}">Edit profile</a>
        </div>
    </section>
@endsection

