<div class="w-[400px] p-8 -mt-10 shadow-lg rounded-md bg-slate-800">
    <h2 class="mb-4 text-center text-xl text-zinc-200 font-semibold">{{ $title }}</h2>
    <form action="{{ route($route) }}" method="POST">
        @csrf
        @method($method)

        
        <div class="space-y-4">
            {{ $slot }}
        </div>


        <button class="block mx-auto mt-6 py-2 px-8 font-normal text-lg rounded-md text-zinc-200 bg-slate-950/60 hover:bg-slate-950/80 transition duration-150" type="submit">{{ $buttonTitle }}</button>
    </form>
</div>