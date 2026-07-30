<div>
    <div
        x-data='OrangeFlashMessage(@json($messages))'
        id="toast-notification"
        class="toast-container position-fixed p-3 top-0 start-50 translate-middle-x"
    ></div>
</div>
@script
<script>
    window.OrangeFlashMessage = (messages) => {
        return {
            messages: messages,
            overlayOptions: {
                backdrop: 'static',
                keyboard: false,
            },
            buildMessage: function (message) {
                if (message.overlay) {
                    var modal = this.buildOverlayModal(message);
                    document.body.appendChild(modal);
                    var modalElement = new bootstrap.Modal(modal, message.important ? self.overlayOptions : {});
                    modalElement.show();
                } else {
                    var toast = this.buildToast(message);
                    document.getElementById('toast-notification').appendChild(toast);
                    var toastElement = new bootstrap.Toast(toast);
                    toastElement.show();
                }
            },
            buildToast: function (message) {
                var toast = document.createElement('div');
                toast.classList.add('toast', 'fade', 'align-items-center', 'text-bg-'+message.level, 'border-'+message.level);
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.setAttribute('data-bs-autohide', message.important ? 'false' : 'true');

                var toastBody = document.createElement('div');
                toastBody.classList.add('d-flex');
                toast.appendChild(toastBody);

                var toastMessage = document.createElement('div');
                toastMessage.classList.add('toast-body');
                toastMessage.innerHTML = message.message;
                toastBody.appendChild(toastMessage);

                var toastClose = document.createElement('button');
                toastClose.classList.add('btn-close', 'me-2', 'm-auto');
                toastClose.setAttribute('type', 'button');
                toastClose.setAttribute('data-bs-dismiss', 'toast');
                toastClose.setAttribute('aria-label', 'Close');
                toastBody.appendChild(toastClose);

                return toast;
            },
            buildOverlayModal: function (message) {
                var modal = document.createElement('div');
                modal.classList.add('modal', 'fade', 'animated', 'fadeInDown');
                modal.setAttribute('wire:ignore', '-1');
                modal.setAttribute('tabindex', '-1');
                modal.setAttribute('aria-labelledby', 'flash-message-modal');
                modal.setAttribute('aria-hidden', 'true');

                var modalDialog = document.createElement('div');
                modalDialog.classList.add('modal-dialog', 'modal-dialog-centered');
                modal.appendChild(modalDialog);

                var modalContent = document.createElement('div');
                modalContent.classList.add('modal-content');
                modalDialog.appendChild(modalContent);

                var modalHeader = document.createElement('div');
                modalHeader.classList.add('modal-header', 'border-0');
                modalContent.appendChild(modalHeader);

                var modalTitle = document.createElement('h5');
                modalTitle.classList.add('modal-title');
                modalTitle.innerHTML = message.title;
                modalHeader.appendChild(modalTitle);

                var modalBody = document.createElement('div');
                modalBody.classList.add('modal-body');
                modalBody.innerHTML = message.message;
                modalContent.appendChild(modalBody);

                var modalFooter = document.createElement('div');
                modalFooter.classList.add('modal-footer', 'border-0');
                modalContent.appendChild(modalFooter);

                var modalOk = document.createElement('a');
                modalOk.classList.add('btn', 'btn-primary');
                modalOk.setAttribute('type', 'button');
                if (message.actionUrl) {
                    modalOk.setAttribute('href', message.actionUrl);
                } else {
                    modalOk.setAttribute('data-bs-dismiss', 'modal');
                }
                modalOk.textContent = message.actionText ?? 'Ok';
                modalFooter.appendChild(modalOk);

                return modal;
            },
            init: function () {
                this.messages.forEach((message) => {
                    this.buildMessage(message);
                });
            },
        }
    }
</script>
@endscript
