<div class="accordion accordion-flush mt-3" id="accordion{{$this->arrayName}}">
    @foreach($accordions as $accordion => $fields)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{$this->arrayName}}{{$loop->index}}">
                <button
                    @class(['accordion-button bg-transparent fw-bold', 'collapsed' => !$loop->first])
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse{{$this->arrayName}}{{$loop->index}}"
                    aria-expanded="{{$loop->first ? 'true' : 'false'}}"
                    aria-controls="collapse{{$this->arrayName}}{{$loop->index}}"
                >@lang($accordion)</button>
            </h2>
            <div
                id="collapse{{$this->arrayName}}{{$loop->index}}"
                @class(['accordion-collapse collapse', 'show' => $loop->first])
                aria-labelledby="heading{{$this->arrayName}}{{$loop->index}}"
                data-bs-parent="#accordion{{$this->arrayName}}"
            >
                <div class="accordion-body p-0">
                    <div class="form-fields mb-0">
                        {!! $this->makePartial('form/form_fields', ['fields' => $fields]) !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
