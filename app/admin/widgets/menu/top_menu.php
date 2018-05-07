<ul id="<?= $this->getId(); ?>"
    class="navbar-nav"
    data-control="mainmenu"
    data-alias="<?= $this->alias; ?>">
    <?php foreach ($items as $item) { ?>
        <?= $this->renderItemElement($item) ?>
    <?php } ?>
</ul>