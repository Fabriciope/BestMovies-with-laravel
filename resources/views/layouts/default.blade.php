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
        <div class="container mx-auto px-2 py-4 flex justify-between">
            <div class="w-[130px]">
                <img class="w-full" src="{{ asset('images/logo-bestmovies.png') }}" alt="logo">
            </div>

            <nav>
                <ul class="flex space-x-3">
                    @auth
                    <li><a href="{{ route('profile.index') }}"
                        class="py-2 px-4 rounded-md text-base font-semibold text-red-700 transition duration-200">profile</a></li>
                    @endauth

                    @guest
                        <li><a href="{{ route('login') }}"
                                class="py-2 px-4 rounded-md text-base font-semibold text-red-700 transition duration-200">Sign
                                in</a></li>
                        <li><a href="{{ route('user.register') }}"
                                class="py-2 px-4 rounded-md text-base font-semibold text-red-700 border-2 border-red-700 hover:bg-red-700 hover:text-slate-900 transition duration-200">Sign
                                up</a></li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto min-h-screen">
        @yield('content')
    </div>

    <footer>

    </footer>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
