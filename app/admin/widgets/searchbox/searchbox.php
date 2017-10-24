<form id="search-form" class="form-inline" accept-charset="utf-8" method="POST" action="<?= current_url(); ?>" role="form">
    <input type="hidden" name="_handler" value="<?= $searchBox->getEventHandler('onSubmit'); ?>">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input
                type="text"
                name="<?= $searchBox->getName() ?>"
                class="form-control <?= $cssClasses ?>"
                value="<?= $value ?>"
                placeholder="<?= $placeholder ?>"
                autocomplete="off"
            />
            <span class="input-group-btn">
            <button class="btn btn-default btn-xs" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </span>
        </div>
    </div>
</form>
