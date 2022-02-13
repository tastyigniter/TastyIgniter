<button
    {!! $button->getAttributes() !!}
    tabindex="0"
>{!! $button->label ?: $button->name !!}</button>
