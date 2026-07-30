<div
    id="{{$this->getId()}}"
    data-control="formwidget"
    data-alias="{{$this->alias}}"
    data-refresh-handler="{{$this->getEventHandler('onRefresh')}}"
    class="form-widget"
    role="form"
>
    {!! $this->makePartial('form/form') !!}
</div>
