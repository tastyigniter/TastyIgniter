<div
    data-control="components"
    data-alias="<?= $this->alias ?>"
    data-handler="<?= $onAddEventHandler ?>"
    data-data="<?= e(json_encode($components)) ?>">

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="panel panel-components">
                <div class="list-group">
                    <?php foreach ($components as $code => $component) { ?>
                        <?php $component = (object)$component; ?>
                        <a
                            class="list-group-item"
                            data-control="add-component"
                            data-component="<?= $component->code ?>"
                            role="button">
                            <h5>
                                <?= e(lang($component->name)) ?>
                            </h5>
                            <p class="small"><?= $component->description ? e(lang($component->description)) : '' ?></p>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 wrap-none wrap-right">
            <div class="partials">
                <div class="row">
                    <div
                        class="col-xs-12 col-md-6">
                        <?php $index = 0; foreach ($themePartials as $partial) { ?>
                            <?php $index++; if (($index % 2) == 0) continue; ?>

                            <?= $this->loadPartial('components/partial', [
                                'partial' => $partial,
                                'index'   => $index,
                            ]); ?>
                        <?php } ?>
                    </div>
                    <div
                        class="col-xs-12 col-md-6">
                        <?php $index = 0; foreach ($themePartials as $partial) { ?>
                            <?php $index++; if (($index % 2) == 1) continue; ?>

                            <?= $this->loadPartial('components/partial', [
                                'partial' => $partial,
                                'index'   => $index,
                            ]); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
