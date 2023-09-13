<label for="{{ $name }}" class="w-full flex flex-col">
    <span class="mb-1 ml-1 font-semibold text-zinc-300">{{ $label }}</span>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="5"
        class="py-2 px-4 rounded-md text-base font-normal resize-y text-zinc-200 border border-slate-700 bg-slate-700/75"
        >{{ $value ?? old($name) }}</textarea>
</label>