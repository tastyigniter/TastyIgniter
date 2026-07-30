<div>
    @unless($message)
        <x-igniter-orange::forms.form
            id="subscribeForm"
            class="subscribe-form"
            wire:submit="onSubscribe"
        >
            <div class="input-group subscribe-group">
                <input
                    wire:model="email"
                    name="email"
                    type="text"
                    class="form-control rounded"
                >
                <button
                    type="submit"
                    id="subscribeButton"
                    class="btn btn btn-light rounded ms-2"
                ><i class="fa fa-paper-plane"></i></button>
            </div>
            <x-igniter-orange::forms.error field="email" class="text-danger" />
        </x-igniter-orange::forms.form>
    @else
        <div class="alert alert-success p-0">
            {{ $message }}
        </div>
    @endunless
</div>
