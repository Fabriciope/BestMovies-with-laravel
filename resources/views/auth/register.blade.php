@extends('layouts.default', ['title' => 'Register'])

@section('content')
<main class="flex justify-center items-center min-w-screen min-h-screen">
    <div class="w-[400px] p-8 -mt-10 shadow-lg rounded-xl bg-slate-800">
        <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">Create new account</h2>
        <x-form :route="route('user.store')" method="post" :files="false">
            <x-box-input label="Name:" type="text" name="name" />
            <x-box-input label="Email:" type="text" name="email" />
            <x-box-input label="Password:" type="password" name="password" />
            <x-box-input label="Password confirmation:" type="password" name="password_confirmation" />
            <button
            class="block mx-auto mt-8 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150"
            type="submit">Register</button>
            <a href="{{ route('login') }}" 
                class="text-sky-600 block mt-2 font-normal text-right text-base hover:underline">Is already registered?</a>
        </x-form>
    </div>
    </div>
</main>
@endsection
