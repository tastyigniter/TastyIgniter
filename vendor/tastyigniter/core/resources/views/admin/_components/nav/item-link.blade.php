@props(['hasChildTarget' => ''])
<a
    {{ $attributes }}
    @if($hasChildTarget)
        data-bs-toggle="collapse"
        data-bs-target="{{$hasChildTarget}}"
    @endif
>
    {{ $slot }}
</a>
