<div class="row">
    @foreach ($schedules as $schedule)
        <div class="col-sm-4">
            <div
                id="{{ $this->getId('item-'.$loop->iteration) }}"
                class="card bg-light shadow-sm mb-2"
                data-editor-control="load-schedule"
                data-schedule-code="{{ $schedule->code }}"
                role="button"
            >
                <div class="card-body">
                    <div class="flex-fill">
                        <h5 class="card-title">{{ ucfirst(strtolower($schedule->code.' '.lang('admin::lang.locations.text_schedule'))) }}</h5>
                        <p class="card-text">{{ lang('admin::lang.locations.text_'.$schedule->config['type']) }}</p>
                    </div>

                    <div class="pt-3">
                        @foreach($schedule->hours as $hour)
                            <div class="d-flex pb-2">
                                <div class="col-5 p-0 text-muted">{{ $hour->day }}</div>
                                <div class="col-7 p-0 text-right text-nowrap text-truncate">
                                    <span title="{{ $hour->hours }}">{{ $hour->hours }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
