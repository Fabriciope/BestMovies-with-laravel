@extends('layouts.default')

@section('content')
<main class="flex justify-center items-center min-w-screen min-h-screen">
    <div class="w-[450px] p-8 -mt-10 shadow-lg rounded-md bg-slate-800">
        <h2 class="text-zinc-200 text-center mb-3 font-semibold text-xl">Verify your email</h2>
        <p class="text-zinc-300 text-center text-base font-normal">
            We send you a link to confirm your account.
            Click on the attached link to verify.
            If you have not received the email, please request a resend.
        </p>
        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <button class="block mx-auto mt-6 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150" type="submit">Resend email verification</button>
        </form>
    </div>
</main>    
@endsection