<div class="dashboard-widget widget-activities">
    <h6 class="widget-title">@lang($this->property('title'))</h6>

    <div class="row">
        <div class="list-group list-group-flush w-100">
            @forelse($activities as $activity)
                <div class="list-group-item bg-transparent">
                    <i class="{{ $activity['icon'] }} fa-fw bg-primary"></i>
                    <b>{{ $activity['causer']['staff_name'] ?? null }}</b>
                    {!! $activity['message'] !!}
                    <em class="pull-right small">{{ time_elapsed($activity['date_added']) }}</em>
                </div>
            @empty
                <div class="list-group-item bg-transparent">@lang('admin::lang.dashboard.text_no_activity')</div>
            @endforelse
        </div>

        <div class="text-right pt-3 px-3 w-100">
            <a href="{{ admin_url('activities') }}">
                @lang('admin::lang.text_see_all_activity')&nbsp;<i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
