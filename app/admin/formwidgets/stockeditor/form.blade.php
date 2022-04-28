<div
    id="{{ $this->getId('form-modal-content') }}"
    class="modal-dialog"
    role="document"
>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ $formTitle ? lang($formTitle) : '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        {!! form_open([
            'id' => 'stock-editor-form',
            'role' => 'form',
            'method' => 'PATCH',
            'data-request' => $this->getEventHandler('onSaveRecord'),
        ]) !!}
        <div
            id="{{ $this->getId('form-modal-fields') }}"
            class="modal-body progress-indicator-container"
        >
            <p>{!! $formDescription !!}</p>
            <div class="accordion" id="{{ $this->getId('stock-locations') }}">
                @foreach($formWidgets as $formWidget)
                    <div class="card">
                        <div
                            class="card-header bg-transparent"
                            id="{{ $formWidget->getId('heading') }}"
                            role="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $formWidget->getId('collapse') }}"
                            aria-expanded="true"
                            aria-controls="{{ $formWidget->getId('collapse') }}"
                        >
                            <h5 class="mb-0">{{ $formWidget->model->location->location_name }}</h5>
                        </div>

                        <div
                            id="{{ $formWidget->getId('collapse') }}"
                            class="collapse {{ $loop->first ? ' show' : '' }}"
                            aria-labelledby="{{ $formWidget->getId('heading') }}"
                            data-parent="#{{ $this->getId('stock-locations') }}"
                        >
                            <div class="card-body">
                                <div class="form-fields p-0">
                                    @foreach ($formWidget->getFields() as $field)
                                        {!! $formWidget->renderField($field) !!}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer text-right">
            <button
                type="button"
                class="btn btn-link"
                data-bs-dismiss="modal"
            >@lang('admin::lang.button_close')</button>
            <button
                type="submit"
                class="btn btn-primary"
                data-attach-loading
            >@lang('admin::lang.button_save')</button>
        </div>
        {!! form_close() !!}
    </div>
</div>
