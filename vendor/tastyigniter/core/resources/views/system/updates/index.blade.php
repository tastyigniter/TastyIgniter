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
        <div class="p-3 border-bottom">
            {!! $this->widgets['toolbar']->render() !!}
        </div>

        @if(!isset($carteInfo['owner']))
            <div class="p-3 text-center">
                <p>
                    <i class="icon fas fa-3x text-danger fa-circle-exclamation"></i>
                </p>
                <p class="fs-5">
                    {!! lang('igniter::system.updates.help_carte_key') !!}
                </p>
            </div>
        @elseif(isset($updates) && ($updates['items']->isNotEmpty() || $updates['ignoredItems']->isNotEmpty()))
            <div id="updates">
                {!! $this->makePartial('updates/list') !!}
            </div>
        @else
            <div class="p-3" id="list-items">
                <h5 class="text-w-400 mb-0">@lang('igniter::system.updates.text_no_updates')</h5>
            </div>
        @endif
    </div>
</div>

{!! $this->makePartial('updates/carte') !!}
