@foreach ($records as $record)
    <div class="card {{ ($record->status) ? 'bg-light shadow-sm' : 'disabled' }} mb-3">
        <div class="card-body p-3">
            <div class="d-flex w-100 align-items-center">
                <div class="mr-4">
                    <span
                        class="extension-icon rounded"
                        style="{{ $record->icon['styles'] ?? '' }}"
                    ><i class="{{ $record->icon['class'] ?? '' }}"></i></span>
                </div>
                <div class="list-action mr-3">
                    @foreach ($columns as $key => $column)
                        @continue($column->type != 'button')
                        @continue(($key == 'install' && $record->status) || ($key == 'uninstall' && !$record->status))
                        {!! $this->makePartial('lists/list_button', ['record' => $record, 'column' => $column]) !!}
                    @endforeach
                </div>

                @foreach ($columns as $key => $column)
                    @continue($column->type == 'button')
                    <div class="flex-grow-1">
                        {!! $this->getColumnValue($record, $column) !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
