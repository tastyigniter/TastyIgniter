@php
    $licence = array_get($carteInfo ?? [], 'licence');
    $alert = array_get($licence, 'alert');
@endphp
@if(filled($alert))
    @php
        $alertClass = match (array_get($alert, 'code')) {
            'installation_bound' => 'alert-success',
            'installation_unbound' => 'alert-warning',
            'installation_mismatch' => 'alert-danger',
            default => 'alert-info',
        };
    @endphp
    <div class="alert {{ $alertClass }} m-3 mt-0">
        <p class="mb-0">{{ array_get($alert, 'message') }}</p>
        @if(filled(array_get($licence, 'bound_url')))
            <p class="mb-0 mt-2 small">
                @lang('igniter::system.updates.text_licence_bound_url'):
                <strong>{{ array_get($licence, 'bound_url') }}</strong>
            </p>
        @endif
    </div>
@endif
