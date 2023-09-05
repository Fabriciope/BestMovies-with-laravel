<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <title>{{ $title ?? 'pegar do .env' }}</title>
</head>
<body class="bg-slate-900">
    <header>
        <div class="container mx-auto px-2 py-4 flex justify-between">
            <div class="w-[130px]">
                <img class="w-full" src="{{ asset('images/logo-bestmovies.png') }}" alt="logo">
            </div>

            <nav>
                <ul class="flex space-x-3">
                    <li><a class="py-2 px-4 rounded text-sm font-semibold text-red-700 transition duration-200" href="">Sign in</a></li>
                    <li><a class="py-2 px-4 rounded text-sm font-semibold text-red-700 border border-red-700 hover:bg-red-600 hover:text-slate-900   transition duration-200" href="">Sign up</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    {{-- @yield('content') --}}

    <footer>

    </footer>

    <script src="https://cdn.tailwindcss.com"></script>
</body>
</html>