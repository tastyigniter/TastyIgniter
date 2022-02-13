@if ($outsideTabs->hasFields())
    {!! $this->makePartial('form/form_section', ['tabs' => $outsideTabs]) !!}
@endif

@if ($primaryTabs->hasFields())
    {!! $this->makePartial('form/form_section', ['tabs' => $primaryTabs]) !!}
@endif

