<?php
$componentNames = [];
if ($record->class) foreach ($record->class->registerComponents() as $component) {
    if (!isset($component['name'])) continue;
    $componentNames[] = lang($component['name']);
}
?>
<h5 class="extension-name<?= (!$record->class) ? ' text-muted' : ''; ?>">
    <?php if ($record->class) { ?>
        <?= $record->title; ?>
    <?php }
    else { ?>
        <s><?= $record->title; ?></s>&nbsp;&nbsp;
    <?php } ?>
    <?php if (count($componentNames)) { ?>
        <span class="">
            <i
                class="extension-label fa fa-cubes"
                title="<?= implode(PHP_EOL, $componentNames); ?>"
            ></i>
        </span>
    <?php } ?>
</h5>
<p class="extension-desc text-muted"><?= $record->meta['description']; ?></p>
