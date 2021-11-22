<div class="modal-content">
    @isset($title)
        <div class="modal-header">
            <h5 class="modal-title">{{ $title }}</h5>

            <x-modal.close/>
        </div>
    @endisset

    <div class="modal-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="modal-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
