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
    <div class="card shadow-sm mx-3">
        {!! form_open(current_url(),
            [
                'id'     => 'edit-form',
                'role'   => 'form',
                'method' => 'PATCH',
            ]
        ) !!}

        <div class="border-bottom">
            {!! $this->toolbarWidget?->render() !!}
        </div>
        {!! $this->formWidget->render() !!}
        {!! form_close() !!}
    </div>
</div>
