<div class="btn-group">
    <button
        type="button"
        class="{{ $button->cssClass }} dropdown-toggle"
        data-bs-toggle="dropdown"
        data-bs-display="static"
        aria-haspopup="true"
        aria-expanded="false"
        tabindex="0"
        {!! $button->getAttributes() !!}
    >{!! $button->label ?: $button->name !!}</button>
    <ul class="dropdown-menu dropdown-menu-left">
        <li><h6 class="dropdown-header px-2">Switch to</h6></li>
        @foreach (['list', 'calendar', 'floor_plan'] as $context)
            <li>
                <a
                    class="dropdown-item px-2 {{$selectedContext === $context ? 'active' : ''}}"
                    href="{{ admin_url('reservations'. ($context !== 'list' ? '/'.$context : '')) }}"
                >@lang('igniter.reservation::default.text_view_'.$context)</a>
            </li>
        @endforeach
    </ul>
</div>
