<div class="grid gap-4 md:grid-cols-2">
    <label class="block text-sm font-medium text-slate-700">
        Name
        <input type="text" name="name" value="{{ old('name', $user?->name) }}" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <span class="mt-1 block text-xs text-red-600">@error('name'){{ $message }}@enderror</span>
    </label>

    <label class="block text-sm font-medium text-slate-700">
        Email
        <input type="email" name="email" value="{{ old('email', $user?->email) }}" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <span class="mt-1 block text-xs text-red-600">@error('email'){{ $message }}@enderror</span>
    </label>

    <label class="block text-sm font-medium text-slate-700">
        Phone
        <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <span class="mt-1 block text-xs text-red-600">@error('phone'){{ $message }}@enderror</span>
    </label>

    <label class="block text-sm font-medium text-slate-700">
        Role
        <select name="role_id" required class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(old('role_id', $user?->role_id) == $role->id)>
                    {{ $role->descriptionLabel() }}
                </option>
            @endforeach
        </select>
        <span class="mt-1 block text-xs text-red-600">@error('role_id'){{ $message }}@enderror</span>
    </label>

    <label class="block text-sm font-medium text-slate-700">
        Password
        <input type="password" name="password" @if (!$user) required @endif class="mt-2 w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <span class="mt-1 block text-xs text-red-600">@error('password'){{ $message }}@enderror</span>
    </label>
</div>

<div class="grid gap-6 rounded-2xl border border-slate-100 bg-slate-50 p-6 md:grid-cols-[140px_1fr] md:items-center">
    <div class="h-28 w-28 overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <img
            src="{{ $user?->avatar_path ? Storage::disk('public')->url($user->avatar_path) : 'https://placehold.co/120x120' }}"
            alt="Avatar"
            class="h-full w-full object-cover"
        >
    </div>

    <div class="space-y-3">
        <label class="block text-sm font-medium text-slate-700">
            Avatar
            <input type="file" name="avatar" accept="image/png,image/jpeg,image/webp" class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 file:shadow-sm">
            <span class="mt-1 block text-xs text-red-600">@error('avatar'){{ $message }}@enderror</span>
        </label>

        @if ($user?->avatar_path)
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="avatar_remove" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Remove current avatar
            </label>
        @endif
    </div>
</div>
