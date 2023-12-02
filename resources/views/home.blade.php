@extends('layouts.default')

@section('content')
    <h1>Hello world!!</h1>

    <div>
        @foreach ($moviesByCategory as $category => $categoryMovies)
            @if (count($categoryMovies) != 0)
                <section class="mb-12">
                    <div class="mb-4 pl-1">
                        <h3 class="mb-2 text-zinc-200 text-2xl font-semibold">All {{ $category }} Movies</h3>
                        <p class="text-zinc-300 text-xl font-semibold">See the latest {{ $category }} movies</p>
                    </div>
                    {{-- Carousel --}}
                    <div class="w-full relative overflow-hidden">
                        <button class="control_movie left  w-[40px] px-1 absolute top-0 bottom-0 left-0 border-none outline-none"
                            style="cursor: pointer;background:  linear-gradient(to left, transparent 0%, black 108%);">
                            <i class="fa-solid fa-chevron-left text-xl text-zinc-200/70 font-bold"></i>
                        </button>
                        <div class="container_movies {{ $category }}  flex gap-5 pl-5 transition-all duration-500 ease-in-out">
                            @foreach ($categoryMovies as $movie)
                                <div class="box_movie w-[264px] h-[410px] shrink-0 bg-center overflow-hidden rounded-md shadow-md bg-cover"
                                    style="background-image: url({{ asset($movie->poster) }})">
                                    <div class="w-full h-full flex flex-col justify-end"
                                        style="background: rgb(0,0,0);background: linear-gradient(0deg, rgba(0,0,0, .93) 3%, rgba(53,53,53, 0) 100%, rgba(255,255,255, 0) 100%);">

                                        <div class="w-full p-4">
                                            <a class="w-full block py-1 text-red-700 drop-shadow-[10px] text-lg text-center font-bold rounded-md border-2 border-red-700 bg-red-700/20"
                                                href="{{ route('movie.show', $movie->id) }}">See more</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="control_movie right  w-[40px] px-1 absolute top-0 bottom-0 right-0 border-none outline-none"
                        style="cursor: pointer;background:  linear-gradient(to right, transparent 0%, black 108%);">
                        <i class="fa-solid fa-chevron-right text-xl text-zinc-200/70 font-bold"></i>
                    </button>
                    </div>
                </section>
            @endif
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/scripts/carousel.js') }}"></script>
@endpush
