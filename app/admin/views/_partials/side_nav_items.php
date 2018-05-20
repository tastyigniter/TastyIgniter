<ul <?= isset($navAttributes) ? Html::attributes($navAttributes) : ''; ?>>
    <?php foreach ($navItems as $code => $menu) { ?>
        <?php
        // Don't display items filtered by user permisions
        if (isset($menu['child']) AND empty($menu['child'])) continue;
        $isActive = $this->isActiveNavItem($code);
        $hasChild = isset($menu['child']) AND count($menu['child']);
        ?>
        <li class="nav-item<?= $isActive ? ' active' : '' ?>">
            <a
                class="nav-link<?= (isset($menu['class'])) ? ' '.$menu['class'] : ''
                ?><?= $hasChild ? ' has-arrow' : ''; ?>"
                href="<?= (isset($menu['href'])) ? $menu['href'] : '#' ?>"
                aria-expanded="<?= $isActive ? 'true' : 'false' ?>"
            >
                <?php if (isset($menu['icon'])) { ?>
                    <i class="fa <?= $menu['icon']; ?> fa-fw"></i>
                <?php } ?>

                <?php if (isset($menu['icon']) AND isset($menu['title'])) { ?>
                    <span class="content"><?= $menu['title'] ?></span>
                <?php } else { ?>
                    <?= $menu['title'] ?>
                <?php } ?>
            </a>

            <?php if ($hasChild) { ?>
                <?= $this->makePartial('side_nav_items', [
                    'navItems'      => $menu['child'],
                    'navAttributes' => [
                        'class'         => 'nav collapse'.($isActive ? ' show' : ''),
                        'aria-expanded' => $isActive ? 'true' : 'false',
                    ],
                ]) ?>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
