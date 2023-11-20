<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title ?? 'pegar do .env' }}</title>
</head>

<body class="bg-slate-900">
    <header class="mb-8">
        <div class="container mx-auto px-2 py-4 flex justify-between items-center">
            <div class="w-[130px]">
                <img class="w-full" src="{{ asset('assets/images/logo-bestmovies.png') }}" alt="logo">
            </div>

            <nav>
                @auth
                    <div class="relative w-full">
                        <button id="menu_button" class="mr-4 p-2 rounded-md hover:bg-slate-800/75 transition duration-150">
                            <i class="fa-solid fa-bars-staggered text-2xl text-zinc-300"></i>
                        </button>
                        <ul id="menu" class="hidden w-[70vw] md:w-[370px] absolute divide-y-2 divide-slate-900 right-0 top-12 rounded-lg shadow-md overflow-hidden bg-slate-700">
                            <li class="w-full">
                                <a href="{{ route('home') }}"
                                    class="block w-full py-2 font-semibold text-lg text-center text-zinc-400 hover:bg-slate-800/25 transition duration-150">
                                    Home
                                </a>
                                <a href="{{ route('profile.index') }}"
                                    class="block w-full py-2 font-semibold text-lg text-center text-zinc-400 hover:bg-slate-800/25 transition duration-150">
                                    Profile
                                </a>
                                <a href="{{ route('profile.dashboard') }}"
                                    class="block w-full py-2 font-semibold text-lg text-center text-zinc-400 hover:bg-slate-800/25 transition duration-150">
                                    My movies
                                </a>
                                <a href="{{ route('movie.create') }}"
                                    class="block w-full py-2 font-semibold text-lg text-center text-zinc-400 hover:bg-slate-800/25 transition duration-150">
                                    Add movie
                                </a>
                            </li>
                        </ul>
                    </div>
                @endauth

                @guest
                    <ul class="flex space-x-3">
                        <li>
                            <a href="{{ route('login') }}"
                                class="py-2 px-4 rounded-md text-base font-semibold text-red-700 transition duration-200">Sign
                                in</a></li>
                        <li>
                            <a href="{{ route('user.register') }}"
                                class="py-2 px-4 rounded-lg text-base font-semibold text-red-700 border-2 border-red-700 hover:bg-red-700 hover:text-slate-900 transition duration-200">Sign
                                up</a></li>
                    </ul>
                @endguest
            </nav>
        </div>
    </header>

    <div class="container mx-auto min-h-screen">
        @yield('content')
    </div>

    <footer>

    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('assets/scripts/menu.js') }}"></script>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font awesome --}}
    <script src="https://kit.fontawesome.com/d5c56409b7.js" crossorigin="anonymous"></script>
</body>

</html>
