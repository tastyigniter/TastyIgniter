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
                        <p class="card-text text-muted">{{ lang('admin::lang.locations.text_'.$schedule->config['type']) }}</p>
                    </div>
                </div>

                <div class="table-responsive px-2">
                    <table class="table table-borderless">
                        <tbody>
                        @foreach($schedule->hours as $hour)
                        <tr>
                            <td class="w-100">{{ $hour->day }}</td>
                            <td class="">
                                <p class="mb-1">{{ $hour->hour->getOpen() }}<span class="text-muted">-{{ $hour->hour->getClose() }}</span></p>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
