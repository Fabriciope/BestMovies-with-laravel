<form 
    action="{{ $route }}" 
    method="post"
    @if ($files) enctype="multipart/form-data" @endif>
    
    @csrf
    @method($method)
    <div class="space-y-6">
        {{ $slot }}
    </div>
</form>
