<div class="btn-group">
    <button
        type="button"
        tabindex="0"
        {!! $button->getAttributes() !!}
    >{!! $button->label ?: $button->name !!}</button>
    @if ($buttonMenuItems = $button->menuItems())
        <button
            type="button"
            class="{{ $button->cssClass }} dropdown-toggle dropdown-toggle-split"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        ><span class="sr-only">Toggle Dropdown</span></button>
        <div class="dropdown-menu">
            @foreach ($buttonMenuItems as $buttonObj)
                {!! $this->renderButtonMarkup($buttonObj) !!}
            @endforeach
        </div>
    @endif
</div>
