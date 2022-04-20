@if (count($components))
    @foreach ($components as $component)
        {!! $this->makePartial('component', [
            'component' => $component,
        ]) !!}
    @endforeach
@endif
