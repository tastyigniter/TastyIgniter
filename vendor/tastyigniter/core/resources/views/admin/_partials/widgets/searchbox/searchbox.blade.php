<form
    id="{{ $searchBox->getId('form') }}"
    accept-charset="utf-8"
    data-request="{{ $searchBox->getEventHandler('onSubmit') }}"
    role="form"
>
    @csrf
    <div class="input-group flex-fill">
        <span class="input-group-text bg-white border-end-0 pe-0"><i class="fa fa-search"></i></span>
        <input
            type="text"
            name="{{ $searchBox->getName() }}"
            class="form-control border-start-0 {{ $cssClasses }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
        />
    </div>
</form>
