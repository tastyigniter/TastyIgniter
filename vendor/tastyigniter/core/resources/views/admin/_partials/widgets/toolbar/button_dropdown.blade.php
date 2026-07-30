@if($buttonMenuItems = $button->menuItems())
    @php($selectedContext = $button->config['context'] ?? '')
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
        <div class="dropdown-menu">
            @isset($button->config['header'])
                <li><h6 class="dropdown-header px-2">@lang($button->config['header'])</h6></li>
            @endisset
            @foreach($buttonMenuItems as $name => $buttonObj)
                @if($selectedContext === $name)
                    @php($buttonObj->config['class'] = ($buttonObj->config['class'] ?? '').' active')
                @endif
                {!! $this->renderButtonMarkup($buttonObj) !!}
            @endforeach
        </div>
    </div>
@endif
