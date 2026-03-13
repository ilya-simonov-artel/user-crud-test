<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<header class="bg-slate-900 text-white" x-data="{ open: false }">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ url('/') }}" class="text-lg font-semibold tracking-wide">
            {{ config('app.name', 'Laravel') }}
        </a>

        <button
            type="button"
            class="rounded-md border border-white/20 p-2 text-white md:hidden"
            @click="open = !open"
            aria-label="Toggle navigation"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        <nav class="hidden items-center gap-4 md:flex">
            <a href="{{ url('/') }}" class="text-sm font-medium text-slate-200 hover:text-white">Home</a>
            @auth
                <a href="{{ route('profile.edit', auth()->user()) }}"
                   class="text-sm font-medium text-slate-200 hover:text-white">Profile</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}"
                       class="text-sm font-medium text-slate-200 hover:text-white">Users</a>
                @endif
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-slate-200 hover:text-white">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-200 hover:text-white">Login</a>
            @endauth
        </nav>
    </div>

    <div class="border-t border-white/10 px-4 pb-4 pt-3 md:hidden" x-cloak x-show="open" x-transition>
        <nav class="flex flex-col gap-3">
            <a href="{{ url('/') }}" class="text-sm font-medium text-slate-200 hover:text-white">Home</a>
            @auth
                <a href="{{ route('profile.edit', auth()->user()) }}"
                   class="text-sm font-medium text-slate-200 hover:text-white">Profile</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}"
                       class="text-sm font-medium text-slate-200 hover:text-white">Users</a>
                @endif
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-left text-sm font-medium text-slate-200 hover:text-white">Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-200 hover:text-white">Login</a>
            @endauth
        </nav>
    </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-8">
    @yield('content')
</main>
</body>
</html>

