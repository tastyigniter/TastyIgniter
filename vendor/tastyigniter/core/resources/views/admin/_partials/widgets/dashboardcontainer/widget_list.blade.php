@foreach ($widgets as $widgetAlias => $widget)
    {!! $this->makePartial('widget_item', [
        'widgetAlias' => $widgetAlias,
        'widget' => $widget,
    ]) !!}
@endforeach
