@extends('layouts.default', ['title' => $movie->title])

@section('content')
    <div class="flex justify-around w-full gap-4 px-3 mb-16">
        <div class="max-w-[500px] w-[55%] hidden lg:block">
            <img class="w-full rounded-lg shadow-lg" src="{{ asset($movie->poster) }}" alt="poster - {{ $movie->title }}">
        </div>
        <div class="lg:w-[61%] w-full flex flex-col">
            <div class="mb-6">
                <h2 class="text-center text-zinc-200 text-2xl mb-6 font-bold">{{ $movie->title }}</h2>

                <div class="sm:flex w-full justify-between px-2">
                    <h4 class="text-zinc-300 font-normal text-lg"><span class="text-zinc-400 text-xl">Duration: </span>
                        {{ $movie->hours() }} hours and {{ $movie->minutes() }} minutes</h4>
                    <h4 class="text-zinc-300 font-normal text-lg"><span class="text-zinc-400 text-xl">Category: </span>
                        {{ $movie->category->category }}</h4>
                    <h4 class="text-zinc-300 font-normal text-lg"><span class="text-zinc-400 text-xl">Rate: </span>{{ $movie->rating  }}</h4>
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
    @can('assess', $movie)
        <div class="w-full lg:w-[55%] mb-12">
            <form action="{{ route('assessment.store', $movie->id) }}" method="post" class="px-2">
                @csrf
                <div class="space-y-3">
                    <div class="flex w-full gap-4">
                        <textarea
                            class="pl-2 border-b border-zinc-300 bg-slate-900 w-full text-zinc-300 text-base font-semibold outline-none @error('comment') border-red-700 @endError"
                            name="comment" rows="2" placeholder="Create a new Assessment" ls-tex>{{ old('comment') ?? '' }}</textarea>

                        <div>
                            <label for="rate" class="text-zinc-200 text-semibold">
                                Rate:
                                <input
                                    class="py-2 px-1 mt-1 w-[51px] rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('rate') ring-1 ring-red-600 @endError"
                                    id="rate" type="number" name="rating" value="{{ old('rating') ?? '' }}">
                            </label>
                        </div>
                    </div>
                </div>

                <button
                    class="block mx-auto md:mx-0 mt-3 py-2 px-6 font-semibold text-sm rounded-md text-zinc-200 bg-red-700 hover:bg-red-700/90 transition duration-150"
                    type="submit">Add assessment</button>

                <div>
                    @error('rating')
                        <small class="mt-1 ml-1 text-red-600 font-normal text-sm block">{{ $message }}</small>
                    @enderror
                    @error('comment')
                        <small class="mt-1 ml-1 text-red-600 font-normal text-sm block">{{ $message }}</small>
                    @enderror
                </div>
            </form>
        </div>
    @endcan
    <div class="space-y-6 px-2">
        @if (count($movie->assessments->all()) > 0)
            @foreach ($movie->assessments->all() as $assessment)                
            <div class="p-3 rounded-lg shadow-sm bg-slate-800 lg:w-[65%] relative">
                <div class="absolute right-2 bottom-2 flex items-center justify-between gap-1">
                    <span class="text-zinc-200 font-normal text-base">Rate: {{ $assessment->rating }}</span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <div class="flex items-center justify-center w-[40px] h-[40px] overflow-hidden rounded-full bg-cover bg-center"
                        style="background-image: url({{ asset($assessment->user->name) }})">
                    </div>
    
                    <a class="text-zinc-300 text-base font-semibold" href="">{{ $assessment->user->name }}</a>
                </div>
                <div class="ml-2">
                    <h5 class="mb-2 text-sm text-zinc-400">Comment:</h5>
                    <p class="ml-1 text-base text-zinc-300">{{ $assessment->comment }}</p>
                </div>
            </div>
            @endforeach
        @endif
    </div>
@endsection
