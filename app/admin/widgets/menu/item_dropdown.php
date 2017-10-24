<?php
$itemOptions = $item->options();
$hasDropdown = count($itemOptions);
?>
<li
    id="<?= $item->getId(); ?>"
    class="menu-link dropdown">
    <a <?= $item->getAttributes(); ?>>
        <i class="fa <?= e($item->icon); ?>" role="button"></i>
        <?php if ($item->badge) { ?>
            <span class="label <?= e($item->badge); ?>"></span>
        <?php } ?>
    </a>

    <ul
        class="dropdown-menu"
        <?php if (!$hasDropdown) { ?>data-request-options="<?= $item->itemName; ?>"<?php } ?>
    >
        <li class="dropdown-header"><?php if ($item->label) { ?><?= e(lang($item->label)); ?><?php } ?></li>
        <?php if ($hasDropdown) { ?>
            <?php foreach ($itemOptions as $key => $value) { ?>
                <li>
                    <a href="<?= admin_url($key); ?>"><?= e(lang($value)); ?></a>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li
                id="<?= $item->getId($item->itemName.'-options'); ?>"
                class="dropdown-body">
                <p class="wrap-all text-muted text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
            </li>
        <?php } ?>
        <li class="dropdown-footer">
            <?php if ($item->menuLink) { ?>
                <a class="text-center" href="<?= admin_url($item->menuLink); ?>"><i class="fa fa-ellipsis-h"></i></a>
            <?php } ?>
        </li>
    </ul>
</li>
