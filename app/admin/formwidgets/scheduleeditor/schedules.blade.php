@foreach ($schedules as $schedule)
    <div
        id="{{ $this->getId('item-'.$loop->iteration) }}"
        class="card bg-light shadow-sm mb-2"
    >
        <div class="card-body">
            <div
                class="flex-fill"
                data-editor-control="load-schedule"
                data-schedule-code="{{ $schedule }}"
                role="button"
            >
                <span class="card-title font-weight-bold">{{ $schedule }}</span>
                &nbsp;-&nbsp;
                <span class="small text-muted">{{ $schedule }}</span>
            </div>
        </div>
    </div>
@endforeach
