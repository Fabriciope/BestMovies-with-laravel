<label for="{{ $name }}" class="w-full flex flex-col">
    <span class="mb-1 ml-1 font-semibold text-zinc-300">{{ $label }}</span>
    <input 
        class="py-2 px-4 rounded-md text-base font-normal text-zinc-200 bg-slate-700/75 focus:shadow transition duration-150 outline-none @error($name) ring-1 ring-red-600 @endError" 
        id="{{ $name }}" 
        type="{{ $type }}" 
        name="{{ $name }}" 
        value="{{ old($name) }}">
    @error($name)
        <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}</small>   
    @enderror
</label>