<?php
$hasPartial = strlen($item->partial);
$itemOptions = $hasPartial ? [] : $item->options();
is_array($itemOptions) OR $itemOptions = [];
?>
<li
    id="<?= $item->getId(); ?>"
    class="nav-item dropdown">
    <a <?= $item->getAttributes(); ?>>
        <i class="fa <?= e($item->icon); ?>" role="button"></i>
        <?php if ($item->badge) { ?>
            <span class="label <?= e($item->badge); ?>"></span>
        <?php } ?>
    </a>

    <ul
        class="dropdown-menu <?= $item->optionsView; ?>"
        <?php if ($hasPartial) { ?>data-request-options="<?= $item->itemName; ?>"<?php } ?>
    >
        <?php if (!$hasPartial) { ?>
            <li class="dropdown-header"><?php if ($item->label) { ?><?= e(lang($item->label)); ?><?php } ?></li>
            <?php foreach ($itemOptions as $key => $value) { ?>
                <li><a class="menu-link" href="<?= $key; ?>"><?= e(lang($value)); ?></a></li>
            <?php } ?>
        <?php } else { ?>
            <li class="dropdown-header"><?php if ($item->label) { ?><?= e(lang($item->label)); ?><?php } ?></li>
            <li
                id="<?= $item->getId($item->itemName.'-options'); ?>"
                class="dropdown-body">
                <p class="wrap-all text-muted text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>
            </li>
        <?php } ?>
        <li class="dropdown-footer">
            <?php if ($item->viewMoreUrl) { ?>
                <a class="text-center" href="<?= $item->viewMoreUrl; ?>"><i class="fa fa-ellipsis-h"></i></a>
            <?php } ?>
        </li>
    </ul>
</li>
