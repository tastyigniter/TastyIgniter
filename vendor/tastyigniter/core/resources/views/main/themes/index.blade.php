<div class="row-fluid">
    <div class="py-3">
        {!! $this->widgets['toolbar']->render() !!}
    </div>

    {!! $this->makePartial('igniter.system::updates/search', ['itemType' => 'theme']) !!}

    {!! $this->widgets['list']->render() !!}
</div>
