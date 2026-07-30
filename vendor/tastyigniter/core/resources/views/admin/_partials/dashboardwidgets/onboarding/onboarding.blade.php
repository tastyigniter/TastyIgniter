<div @class(['dashboard-widget widget-onboarding mx-auto py-4', 'col-6' => $this->property('width') >= 8])">
    <h4 class="widget-title mb-3">@lang('igniter::admin.dashboard.onboarding.title')</h4>
    <div class="list-group list-group-flush w-100">
        @foreach($onboarding->listSteps() as $step)
            @if($step->isCompleted())
                <div class="list-group-item bg-transparent px-0">
                    <i class="fa fa-check-circle-o fa-2x text-success float-left mr-3 my-2"></i>
                    <s class="d-block text-truncate">@lang($step->label)</s>
                    <s class="text-muted">@lang($step->description)</s>
                </div>
            @else
                <a class="list-group-item bg-transparent px-0" href="{{ $step->url }}">
                <span class="fa-stack float-left mr-3 my-2">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa @lang($step->icon) fa-stack-1x fa-inverse"></i>
                </span>
                    <b class="d-block text-truncate">@lang($step->label)</b>
                    <span class="text-muted">@lang($step->description)</span>
                </a>
            @endif
        @endforeach
    </div>
</div>
