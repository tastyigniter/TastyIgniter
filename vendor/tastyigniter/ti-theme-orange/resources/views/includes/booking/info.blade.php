<div class="form-row mb-4">
    <div class="col-sm-3">
        <h5 class="text-muted">@lang('igniter.reservation::default.label_guest_num')</h5>
        <h4 class="font-weight-normal">{{$guest}} @lang($guest > 1 ? 'igniter.reservation::default.text_people' : 'igniter.reservation::default.text_person')</h4>
    </div>
    <div class="col-sm-2">
        <h5 class="text-muted">@lang('igniter.reservation::default.label_date')</h5>
        <h4 class="font-weight-normal">{{ make_carbon($date.' '.$time, false)?->isoFormat(lang('system::lang.moment.date_format')) }}</h4>
    </div>
    <div class="col-sm-2">
        <h5 class="text-muted">@lang('igniter.reservation::default.label_time')</h5>
        <h4 class="font-weight-normal">{{ make_carbon($date.' '.$time, false)?->isoFormat(lang('system::lang.moment.time_format')) }}</h4>
    </div>
    <div class="col-sm-3">
        <h5 class="text-muted">@lang('igniter.reservation::default.label_location')</h5>
        <h4 class="font-weight-normal">{{ $locationCurrent->getName() }}</h4>
    </div>
</div>
<x-igniter-orange::forms.error field="guest" class="text-danger"/>
<x-igniter-orange::forms.error field="time" class="text-danger"/>
<x-igniter-orange::forms.error field="date" class="text-danger"/>
