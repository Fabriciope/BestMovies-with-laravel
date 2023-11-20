<label for="{{ $name }}" class="w-full flex flex-col">
    <span class="mb-1 ml-1 font-semibold text-zinc-300">{{ $label }}</span>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="5"
        class="py-2 px-4 rounded-md text-base font-normal resize-y text-zinc-200 border border-slate-700 bg-slate-700/75 @error($name) ring-1 ring-red-600 @endError">{{$value ?? old($name) }}</textarea>
    @error($name)
        <small class="mt-1 ml-1 text-red-600 font-normal text-sm">{{ $message }}</small>
    @enderror

</label>
