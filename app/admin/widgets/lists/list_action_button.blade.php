@if ($button->type === 'dropdown')
    <div class="dropdown d-inline-block">
        <button
            type="button"
            tabindex="0"
            class="py-1 {{ $button->cssClass }} dropdown-toggle"
            data-bs-toggle="dropdown"
            {!! $button->getAttributes() !!}
        >{!! $button->label ?: $button->name !!}</button>
        @if ($buttonMenuItems = $button->menuItems())
            <div class="dropdown-menu">
                @foreach ($buttonMenuItems as $buttonObj)
                    {!! $this->renderBulkActionButton($buttonObj) !!}
                @endforeach
            </div>
        @endif
    </div>
@else
    <button
        type="button"
        class="py-1 {{ $button->cssClass }}"
        {!! $button->getAttributes() !!}
        data-control="bulk-action"
        data-attach-loading=""
        data-request="{{ $this->getEventHandler('onBulkAction') }}"
        data-request-data="code: '{{ $button->name }}'{{ $button->name === 'delete' ? ",_method:'DELETE'" : '' }}"
        data-request-form="#list-form"
        tabindex="0"
    >{!! $button->label ?: $button->name !!}</button>
@endif
