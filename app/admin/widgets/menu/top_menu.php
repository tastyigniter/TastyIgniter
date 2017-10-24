<ul id="<?= $this->getId(); ?>"
    class="nav navbar-nav navbar-top-links navbar-right"
    data-control="mainmenu"
    data-alias="<?= $this->alias; ?>">
    <?php foreach ($items as $item) { ?>
        <?= $this->renderItemElement($item) ?>
    <?php } ?>
</ul>