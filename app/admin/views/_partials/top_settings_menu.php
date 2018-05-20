<?php
$itemOptions = $item->options();
?>
<li class="nav-item dropdown">
    <a class="nav-link" href="" data-toggle="dropdown">
        <i class="fa fa-gears" role="button"></i>
    </a>

    <ul class="dropdown-menu">
        <div class='menu menu-grid row'>
            <?php foreach ($itemOptions as $label => $value) { ?>
                <?php list($icon, $link) = $value; ?>
                <div class="menu-item col col-4">
                    <a class="menu-link" href="<?= $link; ?>">
                        <i class="<?= $icon; ?>"></i>
                        <span><?= e(lang($label)); ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="dropdown-footer">
            <a class="text-center" href="<?= admin_url('settings'); ?>"><i class="fa fa-ellipsis-h"></i></a>
        </div>
    </ul>
</li>
