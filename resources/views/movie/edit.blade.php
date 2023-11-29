@extends('layouts.default', ['title' => "Edit {$movie->title}"])

@section('content')
    <main class="flex justify-center items-center min-w-screen min-h-screen">
        <div class="w-full lg:flex lg:flex-row lg:justify-center lg:gap-7">
            <div class="w-[550px]  px-4 mx-auto mb-5 lg:mx-0  sm:px-12 pb-12 pt-7 mt-6 shadow-lg rounded-md bg-slate-800">
                <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">Edit movie - {{ $movie->title }}</h2>
                <x-form :route="route('movie.update', $movie->id)" method="PUT" :files="true">

                    <x-box-input label="Film title:" type="text" name="title" :value="$movie->title" />

                    {{-- Film duration inputs --}}
                    <div>
                        <span class="mb-3 ml-1 font-semibold text-zinc-300">Film duration</span>
                        <div class="flex justify-start gap-2 items-center">
                            <div class="flex items-center gap-2">
                                <div>
                                    <input
                                        class="py-2 px-1 w-[51px] rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('hours') ring-1 ring-red-600 @endError"
                                        type="number" name="hours" value="{{ $movie->hours() ?? old('hours') }}">

                                    <span class="mb-1 ml-1 font-semibold text-zinc-400">Hours and</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input
                                        class="py-2 px-1 w-[51px] rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('minutes') ring-1 ring-red-600 @endError"
                                        type="number" name="minutes" value="{{ $movie->minutes() ?? old('minutes') }}">
                                </div>
                                <span class="mb-1 ml-1 font-semibold text-zinc-400">Minutes</span>
                            </div>
                        </div>

                    </div>

                    <div>
                        @if ($category_id = old('category_id'))
                            <select name="category_id" id="category"
                                class="w-[50%] py-2 px-4 rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('category_id') ring-1 ring-red-600 @endError">
                                <option selected value="">Select</option>
                                @foreach ($categories as $category)
                                    <option {{ $category->id == $category_id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="category_id" id="category"
                                class="w-[50%] py-2 px-4 rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('category_id') ring-1 ring-red-600 @endError">
                                <option selected value="">Select</option>
                                @foreach ($categories as $category)
                                    @if ($category->id == $movie->category_id)
                                        <option value="{{ $category->id }}" selected>{{ $category->category }}</option>
                                    @endif
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                                {{-- TODO: resolver problema de old e pra edição --}}
                            </select>
                        @endif
                        @error('category_id')
                            <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}</small>
                        @enderror
                    </div>
                    <x-textarea label="Synopsis:" name="synopsis" :value="$movie->synopsis"/>
                    <x-file-input label="Poster:" name="poster" />
                    <x-box-input label="Trailer:" type="text" name="trailer_link" :value="$movie->shareLink()"/>

                    <button class="block mx-auto md:mx-0 md:ml-auto mt-8 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150" type="submit">Edit movie</button>
                </x-form>
            </div>
            <div class="flex items-center">
                <img src="{{ asset($movie->poster) }}" alt="poster - {{ $movie->poster }}"
                    class="rounded-md mx-auto mt-2 lg:mx-0 shadow-md max-w-[425px]">
            </div>
        </div>
    </main>
@endsection
