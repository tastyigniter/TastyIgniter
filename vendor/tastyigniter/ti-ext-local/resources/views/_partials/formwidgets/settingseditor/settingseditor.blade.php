<div class="accordion" id="accordionSettings">
    @foreach($settings as $group => $setting)
        <div class="accordion-item border rounded-3 mb-2">
            @if((!$currentSettingsCode && $loop->first) || $currentSettingsCode === $setting->code)
                <h2 class="accordion-header">
                    <button
                        class="accordion-button border-0 rounded-top-3 shadow-none bg-light"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ ucfirst($setting->code) }}"
                        aria-expanded="true"
                        aria-controls="collapse{{ ucfirst($setting->code) }}"
                    >@lang($setting->label)</button>
                </h2>
                <div id="collapse{{ ucfirst($setting->code) }}" class="accordion-collapse border-top collapse show" data-bs-parent="#accordionSettings">
                    <div class="accordion-body">
                        {!! $this->renderSettingsForm($setting->code) !!}
                    </div>
                </div>
            @else
                <h2 class="accordion-header">
                    <a class="accordion-button border-0 rounded-3 collapsed"  href="{{ admin_url('locations/settings/' . $this->model->location_id . '/general-' . $setting->code) }}" aria-expanded="false" aria-controls="collapse{{ ucfirst($setting->code) }}">
                        @lang($setting->label)
                    </a>
                </h2>
            @endif
        </div>
    @endforeach
</div>
