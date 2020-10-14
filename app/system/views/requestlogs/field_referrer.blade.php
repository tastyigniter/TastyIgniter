@if ($formModel->referrer AND count($formModel->referrer))
    <div class="form-control-static">
        <ul class="list-unstyled">
            @foreach ($formModel->referrer as $referrer)
                <li>{{ $referrer }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div class="form-control-static">@lang('system::lang.request_logs.text_empty_referrer')</div>
@endif
