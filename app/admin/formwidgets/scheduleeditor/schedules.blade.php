<div class="d-flex flex-nowrap overflow-auto">
    @foreach ($schedules as $scheduleCode => $schedule)
        <div class="col-lg-3 {{ $loop->first ? 'py-2 pr-2 pl-0' : 'p-2' }}">
            <div
                id="{{ $this->getId('item-'.$loop->iteration) }}"
                class="card bg-light shadow-sm mb-0"
                data-editor-control="load-schedule"
                data-schedule-code="{{ $scheduleCode }}"
                role="button"
            >
                <div class="card-body">
                    <div class="flex-fill">
                        <h5 class="card-title">{{ lang($schedule->name).' '.lang('admin::lang.locations.text_schedule') }}</h5>
                        <p class="card-text">{{ lang('admin::lang.locations.text_'.$schedule->type) }}</p>
                    </div>

                    <div class="pt-3">
                        @foreach($schedule->getFormatted() as $value)
                            <div class="d-flex pb-2">
                                <div class="col-5 p-0 text-muted">{{ $value->day }}</div>
                                <div class="col-7 p-0 text-right text-nowrap text-truncate">
                                    <span title="{{ $value->hours }}">{{ $value->hours }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
