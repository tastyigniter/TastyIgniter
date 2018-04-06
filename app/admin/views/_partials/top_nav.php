<?php
$isLogged = AdminAuth::isLogged();
?>
<nav class="navbar navbar-default navbar-top navbar-static-top" role="navigation">
    <div class="container-fluid">
        <?php if ($isLogged) { ?>

            <?= $this->widgets['mainmenu']->render(); ?>

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <h1 class="navbar-heading">
                <?= Template::getHeading(); ?>
            </h1>
        <?php } ?>
    </div>
</nav>
