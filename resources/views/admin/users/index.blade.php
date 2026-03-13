@extends('layouts.app')

@section('content')
    <section class="rounded-2xl bg-white p-8 shadow-sm" x-data="crudUsers({ flashMessage: @js(session('status')) })">
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Users</h2>
            <p class="mt-1 text-sm text-slate-500">Manage all registered users.</p>
        </header>

        <div
            class="mt-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
            x-cloak
            x-show="flashMessage"
            x-text="flashMessage"
        ></div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <form method="get" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, phone" class="w-full min-w-[220px] rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-72">
                <button class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" type="submit">Search</button>
                @if ($search)
                    <a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300" href="{{ route('admin.users.index') }}">Reset</a>
                @endif
            </form>

            <a class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" href="{{ route('admin.users.create') }}">Create user</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-100">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Avatar</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Created</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr class="text-slate-700" data-user-row>
                            <td class="px-4 py-3">
                                <img
                                    class="h-12 w-12 rounded-xl border border-slate-200 bg-white object-cover"
                                    src="{{ $user->avatar_path ? Storage::disk('public')->url($user->avatar_path) : 'https://placehold.co/48x48' }}"
                                    alt="Avatar"
                                >
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->role?->descriptionLabel() ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $user->created_at?->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-sm font-medium text-slate-600 hover:text-slate-500">Edit</a>
                                    <button type="button" class="text-sm font-medium text-red-600 hover:text-red-500" @click="deleteUser($event, '{{ route('admin.users.destroy', $user) }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $users->links('pagination.simple') }}
    </section>
@endsection

