@if (session()->has('success'))
    <div class="message bg-green-600 text-slate-950 rounded-md p-3 text-lg">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="message bg-red-600 text-slate-950 rounded-md p-3 text-lg">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="message bg-yellow-500 text-slate-950 rounded-md p-3 text-lg">
        {{ session('success') }}
    </div>
@endif