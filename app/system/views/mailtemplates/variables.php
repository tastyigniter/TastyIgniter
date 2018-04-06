<div class="panel-group">
    <?php if (count($field->value)) { ?>
        <?php foreach ($field->value as $key => $value) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><?= $key; ?></h4>
                </div>
                <div class="list-group">
                    <?php foreach ($value as $variable) { ?>
                        <div class="list-group-item">
                            <h5>
                                <?= $variable['var']; ?> - <span class="small"><?= $variable['name']; ?></span>
                            </h5>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>