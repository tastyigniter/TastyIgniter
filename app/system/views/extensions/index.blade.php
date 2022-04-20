<div class="row-fluid">
    {!! $this->widgets['toolbar']->render() !!}

    {!! $this->makePartial('updates/search', ['itemType' => 'extension']) !!}

    {!! $this->widgets['list_filter']->render() !!}

    {!! $this->widgets['list']->render() !!}
</div>
