<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PlayerScore')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col min-h-full">
    <!-- Header -->
    <header class="sticky top-0 z-[60] w-full bg-white/80 backdrop-blur-md border-b border-slate-200">
        <nav class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8" aria-label="Global">
            <div class="relative flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a class="flex-none text-xl font-bold text-indigo-600 tracking-tight"
                        href="{{ route('public.players') }}">
                        PlayerScore
                    </a>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden sm:flex sm:items-center sm:gap-x-6">
                    <a class="text-sm font-medium {{ request()->routeIs('public.players', 'public.player') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}"
                        href="{{ route('public.players') }}">
                        Players
                    </a>

                    @auth
                        @can('isAdmin')
                            <div class="w-px h-4 bg-slate-300"></div>
                            <a class="text-sm font-medium {{ request()->routeIs('admin.*') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }} flex items-center gap-x-1"
                                href="{{ route('admin.players') }}">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                Admin
                            </a>
                        @endcan

                        <div class="w-px h-4 bg-slate-300"></div>

                        <!-- User Dropdown -->
                        <div class="hs-dropdown relative inline-flex">
                            <button id="hs-dropdown-basic" type="button"
                                class="hs-dropdown-toggle py-1 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-800 shadow-sm hover:bg-slate-50 disabled:opacity-50 disabled:pointer-events-none transition-all"
                                aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                <i data-lucide="user" class="size-4 text-slate-500"></i>
                                {{ Auth::user()->name }}
                                <i data-lucide="chevron-down"
                                    class="hs-dropdown-open:rotate-180 size-4 text-slate-600 transition-transform"></i>
                            </button>

                            <div class="hs-dropdown-menu transition-[opacity,margin] duration-300 hs-dropdown-open:opacity-100 hs-dropdown-open:block opacity-0 hidden min-w-48 bg-white shadow-md rounded-lg p-2 mt-2 border border-slate-200 z-50"
                                role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-basic">
                                <div class="px-3 py-2 border-b border-slate-100 mb-2">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Account</p>
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-50 focus:outline-none focus:bg-red-50 w-full text-left transition-all">
                                        <i data-lucide="log-out" class="size-4"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="w-px h-4 bg-slate-300"></div>
                        <a class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-all font-semibold"
                            href="{{ route('login') }}">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a class="text-sm font-semibold py-2 px-4 inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none shadow-sm shadow-indigo-200 transition-all"
                                href="{{ route('register') }}">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="sm:hidden">
                    <button type="button"
                        class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-2 rounded-lg border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all text-sm"
                        data-hs-collapse="#navbar-collapse-with-animation"
                        aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
                        <i data-lucide="menu" class="w-4 h-4 hs-collapse-open:hidden"></i>
                        <i data-lucide="x" class="w-4 h-4 hidden hs-collapse-open:block"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div id="navbar-collapse-with-animation"
                class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:hidden">
                <div class="flex flex-col gap-y-4 py-4 border-t border-slate-200">
                    <a class="font-medium {{ request()->routeIs('public.players') ? 'text-indigo-600' : 'text-slate-600' }}"
                        href="{{ route('public.players') }}">
                        Players
                    </a>
                    @auth
                        @can('isAdmin')
                            <a class="font-medium {{ request()->routeIs('admin.*') ? 'text-indigo-600' : 'text-slate-600' }}"
                                href="{{ route('admin.players') }}">
                                Admin Area
                            </a>
                        @endcan
                        <div class="border-t border-slate-100 pt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="font-medium text-red-600 hover:text-red-700 transition-all flex items-center gap-x-2">
                                    <i data-lucide="log-out" class="size-4"></i>
                                    Logout ({{ Auth::user()->name }})
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col gap-y-2 pt-2">
                            <a class="font-medium text-slate-600 hover:text-slate-900" href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                <a class="font-medium text-indigo-600 hover:text-indigo-700"
                                    href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-auto w-full max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <p class="text-sm text-slate-500">© {{ date('Y') }} PlayerScore. All rights reserved.</p>
                <div class="flex items-center gap-x-4">
                    <a class="text-slate-400 hover:text-slate-600" href="#">
                        <i data-lucide="github" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>