@foreach ($records ?? [] as $theme)
    @unless ($theme->getTheme())
        {!! $this->makePartial('lists/not_found', ['theme' => $theme]) !!}
    @else
        <div class="row mb-3">
            <div class="d-flex align-items-center bg-light p-4 w-100">
                @if ($theme->getTheme()->hasParent())
                    {!! $this->makePartial('lists/child_theme', ['theme' => $theme]) !!}
                @else
                    <a
                        class="media-left mr-4 preview-thumb"
                        data-bs-toggle="modal"
                        data-bs-target="#theme-preview-{{ $theme->code }}"
                        data-img-src="{{ URL::asset($theme->screenshot) }}"
                        style="width:200px;">
                        <img
                            class="img-responsive img-rounded"
                            alt=""
                            src="{{ URL::asset($theme->screenshot) }}"
                        />
                    </a>
                    <div class="media-body">
                        <span class="h5 media-heading">{{ $theme->name }}</span>&nbsp;&nbsp;
                        <span class="small text-muted">
                            {{ $theme->code }}&nbsp;-&nbsp;
                            {{ $theme->version }}
                            @lang('system::lang.themes.text_author')
                            <b>{{ $theme->author }}</b>
                        </span>
                        @unless ($theme->getTheme()->hasParent())
                            <p class="description text-muted mt-3">{{ $theme->description }}</p>
                        @endunless
                        <div class="list-action align-self-end my-3">
                            {!! $this->makePartial('lists/list_buttons', ['theme' => $theme]) !!}
                        </div>
                    </div>
                @endif
            </div>
            @if (strlen($theme->screenshot))
                {!! $this->makePartial('lists/screenshot', ['theme' => $theme]) !!}
            @endif
        </div>
    @endunless
@endforeach
