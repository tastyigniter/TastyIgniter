<div class="card">
    <div class="list-group list-group-flush">
        <?php foreach ($availableComponents as $component) { ?>
            <a
                class="list-group-item list-group-item-action"
                data-control="add-component"
                data-component-code="<?= $component->code; ?>"
                role="button"
            >
                <h5><?= e(lang($component->name)) ?></h5>
                <h6 class="text-muted"><?= $component->description ? e(lang($component->description)) : '' ?></h6>
            </a>
        <?php } ?>
    </div>
</div>
