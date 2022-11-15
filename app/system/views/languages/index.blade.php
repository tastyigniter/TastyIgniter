<div class="row-fluid">
    {!! $this->widgets['toolbar']->render() !!}

    {!! $this->makePartial('updates/search', ['itemType' => 'language']) !!}

    {!! $this->widgets['list_filter']->render() !!}

    {!! $this->widgets['list']->render() !!}
</div>

