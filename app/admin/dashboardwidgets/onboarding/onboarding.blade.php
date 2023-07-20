<div class="dashboard-widget widget-onboarding">
    <h6 class="widget-title">@lang('admin::lang.dashboard.onboarding.title')</h6>
    <div class="row">
        <div class="list-group list-group-flush w-100">
            @foreach($onboarding->listSteps() as $step)
                @if(($completed = $step->completed) && $completed())
                    <div class="list-group-item bg-transparent">
                        <i class="fa fa-check-circle-o fa-2x text-success float-left mr-3 my-2"></i>
                        <s class="d-block text-truncate">@lang($step->label)</s>
                        <s class="text-muted d-block text-truncate">@lang($step->description)</s>
                    </div>
                @else
                    <a class="list-group-item bg-transparent" href="{{ $step->url }}">
                    <span class="fa-stack float-left mr-3 my-2">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa @lang($step->icon) fa-stack-1x fa-inverse"></i>
                    </span>
                        <b class="d-block text-truncate">@lang($step->label)</b>
                        <span class="text-muted d-block text-truncate">@lang($step->description)</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
