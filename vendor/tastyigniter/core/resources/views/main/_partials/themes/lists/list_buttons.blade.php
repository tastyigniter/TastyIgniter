@if(array_has($this->getColumns(), 'source'))
    {!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('source')]) !!}
@endif

@if ($theme->getTheme()->hasCustomData())
    {!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('edit')]) !!}
@endif

{!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('default')]) !!}

{!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) !!}
