@extends('layouts.default', ['title' => $movie->title])

@section('content')
    <main class="flex justify-center items-start min-w-screen min-h-screen">
        <div class="flex justify-around w-full gap-4 px-3">
            <div class="max-w-[500px] w-[55%] hidden lg:block">
                <img class="w-full rounded-lg shadow-lg" src="{{ asset($movie->poster) }}" alt="poster - {{ $movie->title }}">
            </div>
            <div class="lg:w-[61%] w-full flex flex-col">
                <div class="mb-6">
                    <h2 class="text-center text-zinc-200 text-2xl mb-6 font-bold">{{ $movie->title }}</h2>

                    <div class="sm:flex w-full justify-between px-2">
                        <h4 class="text-zinc-400 font-normal text-lg"><span class="text-zinc-300 text-xl">Duration: </span> {{ $movie->hours() }} hours and {{ $movie->minutes() }} minutes</h4>
                        <h4 class="text-zinc-400 font-normal text-lg"><span class="text-zinc-300 text-xl">Category: </span> {{ $movie->category->category }}</h4>
                        <h4 class="text-zinc-400 font-normal text-lg"><span class="text-zinc-300 text-xl">Rate: </span> without rate</h4>
                    </div>
                </div>
                <div>
                    <div class="w-full pb-[56.25%] relative z-20 rounded-md shadow-md overflow-hidden mb-5">
                        <iframe class="absolute border-none w-full h-full" src="{{ $movie->trailer_link }}"
                            title="{{ $movie->title }}"></iframe>
                    </div>
                    <p class="font-normal text-zinc-300 text-base text-left">{{ $movie->synopsis }}</p>
                </div>
            </div>
        </div>
        <div></div>
    </main>
@endsection
