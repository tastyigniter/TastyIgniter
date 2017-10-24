<li
    id="<?= $item->getId(); ?>"
    class="menu-link">
    <a <?= $item->getAttributes(); ?>>
        <i class="fa <?= e($item->icon); ?>"></i>
        <?php if ($item->badge) { ?>
            <span class="label <?= e($item->badge); ?>"></span>
        <?php } ?>
        <?php if ($item->label) { ?>
            <span><?= e(lang($item->label)); ?></span>
        <?php } ?>
    </a>
</li>
