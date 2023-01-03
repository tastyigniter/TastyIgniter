<div
    id="{{ $this->getId() }}"
    class="mediafinder {{ $mode }}-mode{{ $isMulti ? ' is-multi' : '' }}{{ $value ? ' is-populated' : '' }}"
    data-control="mediafinder"
    data-alias="{{ $this->alias }}"
    data-mode="{{ $mode }}"
    data-choose-button-text="{{ $chooseButtonText }}"
    data-use-attachment="{{ $useAttachment }}"
>
    {!! $this->makePartial('mediafinder/image') !!}

    @if ($useAttachment)
        <script type="text/template" data-config-modal-template>
            <div class="modal-dialog">
                <div id="{{ $this->getId('config-modal-content') }}">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="progress-indicator">
                                <span class="ti-loading spinner-border fa-3x fa-fw"></span>
                                @lang('admin::lang.text_loading')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    @endif
</div>
