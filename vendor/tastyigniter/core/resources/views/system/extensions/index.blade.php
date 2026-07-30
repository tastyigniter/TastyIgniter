<div class="d-flex p-3">
    @if($previousUrl = AdminMenu::getPreviousUrl())
        <a
            class="btn shadow-none border-none ps-0"
            href="{{$previousUrl}}"
        ><i class="fa fa-angle-left fs-4 align-bottom"></i></a>
    @endif
    <h4 class="page-title mb-0 lh-base">
        <span>{!! Template::getHeading() !!}</span>
    </h4>
</div>
<div class="row-fluid">
    <div class="row align-items-center pb-3">
        <div class="col-lg-9 pe-0">
            {!! $this->widgets['toolbar']->render() !!}
        </div>
        <div class="col-lg-3">
            {!! $this->widgets['list_filter']->render() !!}
        </div>
    </div>

    {!! $this->makePartial('updates/search', ['itemType' => 'extension']) !!}

    {!! $this->widgets['list']->render() !!}
</div>
