<?php foreach ($listRecord->components->pluck('module_code')->unique() as $componentCode) { ?>
    <?php
    $componentMeta = \System\Classes\ComponentManager::instance()->findComponent($componentCode);
    ?>
    <span class="label label-<?= ($componentMeta) ? 'primary' : 'default'; ?>">
        <?= (!$componentMeta) ? $componentCode : e(lang($componentMeta['name'])); ?>
    </span>&nbsp;&nbsp;
<?php } ?>
