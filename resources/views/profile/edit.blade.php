@extends('layouts.app')

@section('content')
    <section
        class="rounded-2xl bg-white p-8 shadow-sm"
        x-data="profileEditor({
            initialMessage: @js(session('status')),
            initialErrors: @js($errors->toArray()),
            initialAvatarUrl: @js($user->avatar_path ? Storage::disk('public')->url($user->avatar_path) : 'https://placehold.co/120x120')
        })"
    >
        <header>
            <h2 class="text-xl font-semibold text-slate-900">Edit Profile</h2>
            <p class="mt-1 text-sm text-slate-500">Update your personal details and avatar.</p>
        </header>

        <div
            id="profile-success"
            class="mt-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
            x-cloak
            x-show="successMessage"
            x-text="successMessage"
        ></div>

        <form
            id="profile-form"
            x-ref="form"
            method="post"
            action="{{ route('profile.update', $user) }}"
            enctype="multipart/form-data"
            class="mt-6 space-y-6"
            @submit.prevent="submit"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-3">
                <label class="block text-sm font-medium text-slate-700">
                    Name
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="mt-1 block text-xs text-red-600" data-field-error="name" x-text="errors.name ? errors.name.join(' ') : ''"></span>
                </label>

                <label class="block text-sm font-medium text-slate-700">
                    Email
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="mt-1 block text-xs text-red-600" data-field-error="email" x-text="errors.email ? errors.email.join(' ') : ''"></span>
                </label>

                <label class="block text-sm font-medium text-slate-700">
                    Phone
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000" class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="mt-1 block text-xs text-red-600" data-field-error="phone" x-text="errors.phone ? errors.phone.join(' ') : ''"></span>
                </label>
            </div>

            <div class="grid gap-6 rounded-2xl border border-slate-100 bg-slate-50 p-6 md:grid-cols-[140px_1fr] md:items-center">
                <div class="h-28 w-28 overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <img
                        :src="avatarPreview"
                        alt="Profile avatar"
                        class="h-full w-full object-cover"
                        data-avatar-preview
                    >
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-slate-700">
                        Avatar
                        <input type="file" name="avatar" accept="image/png,image/jpeg,image/webp" data-avatar-input class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 file:shadow-sm" @change="previewAvatar">
                        <span class="mt-1 block text-xs text-red-600" data-field-error="avatar" x-text="errors.avatar ? errors.avatar.join(' ') : ''"></span>
                    </label>

                    @if ($user->avatar_path)
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="avatar_remove" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            Remove current avatar
                        </label>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500" :disabled="isSaving" :class="isSaving ? 'opacity-70' : ''">
                    <span x-text="isSaving ? 'Saving...' : 'Save'"></span>
                </button>
                <a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-slate-300" href="{{ route('profile.show', $user) }}">View profile</a>
            </div>
        </form>

        <form method="post" action="{{ route('profile.destroy', $user) }}" class="mt-6" data-profile-delete @submit.prevent="confirmDelete">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Delete account</button>
        </form>
    </section>
@endsection

