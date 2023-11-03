<label for="{{ $name }}" class="w-full mt-3 flex flex-col">
    <span class="block mb-1 ml-1 font-semibold text-zinc-300">{{ $label }}</span>
    <input type="file" name="{{ $name }}" id="{{ $name }}"
        class="block w-full rounded-md border border-slate-700/80 bg-slate-700/40 text-zinc-500 font-normal file:bg-slate-700 file:border-0 file:p-3 file:text-zinc-300/75 file:font-semibold file:cursor-pointer file:hover:bg-slate-700/80 file:transition file:duration-150">
        {{-- Colocar os tipos de arquivos aceitos --}}
    @error($name)
        <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}</small>
    @enderror
</label>
