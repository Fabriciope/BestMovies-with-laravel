@extends('layouts.default', ['title' => 'Profile'])

@section('content')
<main class="flex justify-center items-center min-w-screen min-h-screen">
    <div class="px-4 sm:px-12 pb-12 pt-7 mt-6 shadow-lg rounded-md bg-slate-800">
        <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">My profile</h2>
        <x-form route="user.update" method="post" :files="true">
            <div class="md:flex md:gap-12">
                <div>
                    <div class="border rounded-xl border-slate-700 p-5">
                        <div class="w-[180px] h-[180px] mx-auto mb-2 rounded-2xl shadow-md overflow-hidden">
                            <img src="{{ $user->photo ? asset("storage/{$user->photo}") : asset('assets/images/photo-default.jpg')}}" 
                                class="w-[100%] h-[100%] object-cover" alt="profile photo default">
                        </div>
                        <x-file-input label="Photo:" name="photo" />
                    </div>
                    @if ($verifiedEmail)
                        <div class="flex justify-end mt-3">
                            <div class="flex py-2 px-4 rounded-lg bg-slate-900/40">
                                <img src="{{ asset('images/verify.png') }}" 
                                    class="h-full w-5 mr-2"
                                    alt="selo de email verificado">
                                <span class=" text-zinc-300 text-sm font-semibold">Verified email</span>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-end mt-3">
                            <div
                            class="inline-block cursor-pointer py-2 px-4 rounded-lg hover:bg-sky-600/90 transition duration-150 bg-sky-600">
                            <i class="fa-solid fa-envelope text-zinc-300 mr-2"></i>
                            <a href="{{ route('verification.notice') }}" class="text-zinc-300 font-semibold text-sm">Verify
                                    email</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="md:w-[400px] space-y-5">
                    <x-box-input label="Name:" type="text" name="name" :value="$user->name" />
                    <x-textarea label="Description:" name="description" :value="$user->description" />
                </div>
            </div>

            <button
                class="block mx-auto md:mx-0 md:ml-auto mt-8 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150"
                type="submit">Save</button>
        </x-form>
    </div>
</main>
@endsection
