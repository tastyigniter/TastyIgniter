<div class="row-fluid">
    {!! $this->widgets['toolbar']->render() !!}

    {!! $this->makePartial('updates/search', ['itemType' => 'theme']) !!}

    {!! $this->widgets['list']->render() !!}
</div>
