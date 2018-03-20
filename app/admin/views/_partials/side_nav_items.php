<ul class="<?= $cssClass; ?>" id="side-menu">
    <?php foreach ($navItems as $code => $menu) { ?>
        <?php
        if (isset($menu['child']) AND empty($menu['child'])) continue;
        ?>
        <li
            <?= $this->isActiveNavItem($code) ? 'class="active"' : '' ?>
        >
            <a
                <?= (isset($menu['class'])) ? 'class="'.$menu['class'].'"' : '' ?>
                <?= (isset($menu['href'])) ? 'href="'.$menu['href'].'"' : '' ?>
            >
                <?php if (isset($menu['icon'])) { ?>
                    <i class="fa <?= $menu['icon']; ?> fa-fw"></i>
                <?php } else { ?>
                    <i class="fa fa-square-o fa-fw"></i>
                <?php } ?>

                <?php if (isset($menu['icon']) AND isset($menu['title'])) { ?>
                    <span class="content"><?= $menu['title'] ?></span>
                <?php } else { ?>
                    <?= $menu['title'] ?>
                <?php } ?>

                <?php if (isset($menu['child']) AND is_array($menu['child'])) { ?>
                    <span class="fa arrow"></span>
                <?php } ?>
            </a>

            <?php if (isset($menu['child']) AND count($menu['child'])) { ?>
                <?= $this->makePartial('side_nav_items', [
                    'navItems' => $menu['child'],
                    'cssClass' => 'nav nav-second-level',
                ]) ?>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
