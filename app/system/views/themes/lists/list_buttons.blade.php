{!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('source')]) !!}

@if ($theme->getTheme()->isActive() && $theme->getTheme()->hasCustomData())
    {!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('edit')]) !!}
@endif

{!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('default')]) !!}

{!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) !!}
