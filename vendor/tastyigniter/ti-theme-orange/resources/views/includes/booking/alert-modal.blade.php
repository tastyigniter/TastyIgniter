<div
    x-data="{ modalMessage: '', modalException: '' }"
    x-init="
        window.addEventListener('submit', (event) => {
            if (event.target.matches('#booking-form')) {
                const modalEl = document.getElementById('booking-alert-modal');
                const bookingAlertModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                bookingAlertModal.show();
            }
        });

        window.addEventListener('hidden.bs.modal', (event) => {
            if (event.target.matches('#booking-alert-modal')) {
                modalMessage = '';
                modalException = '';
            }
        });

        $wire.on('booking::alert', (event) => {
            $nextTick(() => {
                if (event.show) {
                    modalMessage = event.message;
                    modalException = event.exception;
                } else {
                    modalMessage = '';
                    modalException = '';
                    setTimeout(() => {
                        const modalEl = document.getElementById('booking-alert-modal');
                        const bookingAlertModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        bookingAlertModal.hide();
                    }, 300);
                }
            });
        });
    "
>
    <div
        wire:ignore.self
        id="booking-alert-modal"
        class="modal fade"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="bookingAlertModal"
        aria-hidden="true"
        x-transition
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div x-show="!modalMessage.length" class="modal-body text-center">
                    <div class="fa-5x">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <p class="lead">@lang('igniter.orange::default.text_please_wait_info')</p>
                </div>
                <div x-show="modalMessage.length" class="modal-body text-center">
                    <div class="fa-5x text-warning">
                        <i class="fa fa-triangle-exclamation"></i>
                    </div>
                    <p class="lead" x-text="modalMessage"></p>
                    <p class="text-danger" x-text="modalException"></p>
                    <div class="justify-content-center">
                        <button
                            class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal"
                        >@lang('igniter::admin.button_close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
