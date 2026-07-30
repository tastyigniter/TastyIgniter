@foreach($records ?? [] as $theme)
    <div class="card shadow-sm  mb-3">
        <div class="d-flex align-items-center p-4 w-100">
            @unless($theme->getTheme())
                {!! $this->makePartial('themes/not_found', ['theme' => $theme]) !!}
            @elseif ($theme->getTheme()->hasParent())
                {!! $this->makePartial('themes/child_theme', ['theme' => $theme]) !!}
            @else
                <a
                    class="mr-4 preview-thumb"
                    data-bs-toggle="modal"
                    data-bs-target="#theme-preview-{{ $theme->code }}"
                    data-img-src="{{ URL::asset($theme->screenshot) }}"
                    style="width:200px;">
                    @if (strlen($theme->screenshot))
                        <img
                            class="img-responsive img-rounded"
                            alt=""
                            src="{{ $theme->screenshot }}"
                        />
                    @endif
                </a>
                <div>
                    <span class="h5 media-heading">{{ $theme->name }}</span>&nbsp;&nbsp;
                    <span class="small text-muted">
                            {{ $theme->code }}&nbsp;-&nbsp;
                            {{ $theme->version }}
                        @lang('igniter::system.themes.text_author')
                            <b>{{ $theme->author }}</b>
                        </span>
                    @unless($theme->getTheme()->hasParent())
                        <p class="description text-muted mt-3">{{ $theme->description }}</p>
                    @endunless
                    <div class="list-action align-self-end my-3">
                        {!! $this->makePartial('lists/list_buttons', ['theme' => $theme]) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (strlen($theme->screenshot))
        {!! $this->makePartial('themes/screenshot', ['theme' => $theme]) !!}
    @endif
@endforeach
