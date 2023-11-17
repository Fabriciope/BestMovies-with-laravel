@extends('layouts.default', ['title' => 'Add movie'])

@section('content')
    <main class="flex justify-center items-center min-w-screen min-h-screen">
        <div class="px-4 sm:px-12 pb-12 pt-7 mt-6 shadow-lg rounded-md bg-slate-800">
            <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">Register new movie</h2>
            <x-form route="user.update" method="post" :files="true">
                
                <x-box-input label="Film title:" type="text" name="title" />
                
                {{-- Film duration inputs --}}
                <div>
                    <span class="mb-3 ml-1 font-semibold text-zinc-300">Film duration</span>
                    <div class="flex justify-start gap-2 items-center">
                        <div class="flex items-center gap-2">
                            <div>
                                <input
                                class="py-2 px-1 w-[51px] rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('hours') ring-1 ring-red-600 @endError"
                                type="number" name="hours" value="{{ old('hours') }}">
                                @error('hours')
                                <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}<small>
                                    @enderror
                                </div>
                                <span class="mb-1 ml-1 font-semibold text-zinc-400">Hours and</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div>
                                <input
                                    class="py-2 px-1 w-[51px] rounded-md text-base font-normal text-zinc-200 border border-slate-700 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error('minutes') ring-1 ring-red-600 @endError"
                                    type="number" name="minutes" value="{{ old('minutes') }}">
                                    @error('minutes')
                                    <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}</small>
                                    @enderror
                                </div>

                                <span class="mb-1 ml-1 font-semibold text-zinc-400">Minutes</span>
                            </div>
                    </div>
                </div>
                
                <x-textarea label="Synopsis:" name="synopsis" />
                <x-file-input label="Banner:" name="banner" />
                <x-box-input label="Trailer:" type="text" name="trailer" />

                <button
                    class="block mx-auto md:mx-0 md:ml-auto mt-8 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150"
                    type="submit">Create movie</button>
            </x-form>
        </div>
    </main>
@endsection
