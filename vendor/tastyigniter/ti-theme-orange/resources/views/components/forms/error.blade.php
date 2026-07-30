@props(['field', 'bag' => 'default'])
@error($field, $bag)
<div {{ $attributes }}>
    @if ($slot->isEmpty())
        {{ $message }}
    @else
        {{ $slot }}
    @endif
</div>
@enderror
