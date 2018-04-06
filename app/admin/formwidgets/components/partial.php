<div
    data-control="partial"
    data-partial="<?= $partial->id; ?>"
    data-sortable-container="<?= $this->getId($partial->id); ?>">

    <div
        id="<?= $this->getId($partial->id); ?>"
        class="panel panel-group panel-partial">
        <div
            class="panel-heading"
            data-target="#<?= $this->getId('partial-'.$partial->id); ?>"
            aria-expanded="true"
            aria-controls="<?= $this->getId('partial-'.$partial->id); ?>">
            <h4 class="panel-title text-muted"><b><?= $partial->name; ?></b></h4>
        </div>

        <div
            id="<?= $this->getId('partial-'.$partial->id); ?>"
            class="is-sortable panel-body collapse in"
            role="tablist" aria-multiselectable="true">

            <?php $partialComponents = $this->getPartialComponents($partial) ?>
            <?php $indexValue = 0;
            foreach ($partialComponents as $component) { ?>
                <?php $indexValue++; ?>

                <?= $this->makePartial('components/component', [
                    'component' => $component,
                    'index'     => $indexValue,
                ]) ?>

            <?php } ?>

        </div>
    </div>

</div>
