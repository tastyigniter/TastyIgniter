<div class="d-flex p-3">
    @if($previousUrl = AdminMenu::getPreviousUrl())
        <a
            class="btn shadow-none border-none ps-0"
            href="{{ $previousUrl }}"
        ><i class="fa fa-angle-left fs-4 align-bottom"></i></a>
    @endif
    <h4 class="page-title mb-0 lh-base">
        <span>{!! Template::getHeading() !!}</span>
    </h4>
</div>
<div class="row-fluid">
    <div class="card shadow-sm mx-3">
        <div class="border-bottom">
            {!! $this->widgets['toolbar']->render() !!}
        </div>

        <div class="p-3" id="system-page-content">
            {!! $this->makePartial('system/page_content') !!}
        </div>
    </div>
</div>
