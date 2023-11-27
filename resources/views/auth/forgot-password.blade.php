@extends('layouts.default')

@section('content')
<main class="flex justify-center items-center min-w-screen min-h-screen">
    <div class="w-[400px] p-8 -mt-10 shadow-lg rounded-md bg-slate-800">
        <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">Requests password reset</h2>
        <x-form :route="route('password.email')" method="post" :files="false">
           {{-- Implementar limite de requisição  --}}
            <x-box-input label="Email:" type="text" name="email" />
            <button class="block mx-auto mt-8 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150"
                type="submit">Send email</button>
        </x-form>
    </div>
    </div>
</main> 
@endsection