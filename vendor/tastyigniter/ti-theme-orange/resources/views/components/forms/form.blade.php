@props(['method' => 'POST', 'action' => null, 'hasFiles' => FALSE])
<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" @isset($action) action="{{ $action }}" @endisset {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }}>
    @csrf
    @method($method)
    {{ $slot }}
</form>
