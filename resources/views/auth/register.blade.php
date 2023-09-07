@extends('layouts.default', ['title' => 'Register'])

@section('content')
    <main class="flex justify-center items-center min-w-screen min-h-screen">
        <x-form title="Create new account" route="user.store" method="post" button-title="Register">
            <x-box-input label="Name:" type="text" name="name" />
            <x-box-input label="Email:" type="text" name="email" />
            <x-box-input label="Password:" type="password" name="password" />
            <x-box-input label="Password confirmation:" type="password" name="password_confirmation" />
        </x-form>
    </main>   
@endsection