@props(['name'])

@if($errors->has($name))
    <span class="input-error">{{ $errors->first($name) }}</span>
@endif
