@extends('layouts.app')

@section('content')
    <section class="rounded-2xl bg-white p-8 shadow-sm">
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Edit user</h2>
            <p class="mt-1 text-sm text-slate-500">Update user details.</p>
        </header>

        @if (session('status'))
            <div class="mt-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <form method="post" action="{{ route('admin.users.update', $user) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.users.partials.form', ['user' => $user])

            <div class="flex flex-wrap items-center gap-3">
                <button class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" type="submit">Save</button>
                <a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300" href="{{ route('admin.users.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

