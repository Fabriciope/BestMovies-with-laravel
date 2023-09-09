@extends('layouts.default', ['title' => 'Login'])

@section('content')
    <main class="flex justify-center items-center min-w-screen min-h-screen">
        <x-form title="Sign in to your account" route="login.store" method="post" button-title="Login">
            <x-box-input label="Email:" type="text" name="email" />
            <x-box-input label="Password:" type="password" name="password" />
        </x-form>
    </main>   
@endsection