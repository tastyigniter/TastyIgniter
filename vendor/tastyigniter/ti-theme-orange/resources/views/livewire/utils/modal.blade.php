<div
    class="modal fade"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    id="orange-modal"
    tabindex="-1"
    aria-hidden="true"
    style="z-index: 9999;"
    wire:ignore.self
>
    @if ($component)
        @livewire($component, $arguments, key($activeModal))
    @else
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="ti-loading spinner-border fa-3x fa-fw" role="status"></div>
                        <div class="fw-bold mt-2">Loading...</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
