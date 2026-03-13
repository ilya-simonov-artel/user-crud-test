@extends('layouts.app')

@section('content')
    <section class="rounded-2xl bg-white p-8 shadow-sm">
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Create user</h2>
            <p class="mt-1 text-sm text-slate-500">Add a new user account.</p>
        </header>

        <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf

            @include('admin.users.partials.form', ['user' => null])

            <div class="flex flex-wrap items-center gap-3">
                <button class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" type="submit">Create</button>
                <a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300" href="{{ route('admin.users.index') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection

