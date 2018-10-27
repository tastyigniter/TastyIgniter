<?php
$isLogged = AdminAuth::isLogged();
?>
<div class="sidebar" role="navigation">
    <div id="navSidebar" class="nav-sidebar">
        <?= $this->makePartial('side_nav_items', [
            'navItems' => $navItems,
            'navAttributes' => [
                'id' => 'side-nav-menu',
                'class' => 'nav',
            ],
        ]) ?>
    </div>
</div>
