@props([
    'method' => 'POST',
    'hasFiles' => FALSE,
])
<form
    method="{{ $method }}"
    action="{{ $action ?? current_url() }}"
    {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!}
    {{ $attributes }}
>
    @csrf
    @method($method)

    {{ $slot }}
</form>
