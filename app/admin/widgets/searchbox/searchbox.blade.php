<div class="input-group flex-fill">
    <input
        type="text"
        name="{{ $searchBox->getName() }}"
        class="form-control {{ $cssClasses }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
    />
    <button
        class="btn btn-light"
        type="submit"
        data-request="{{ $searchBox->getEventHandler('onSubmit') }}"
    >
        <i class="fa fa-search"></i>
    </button>
</div>
