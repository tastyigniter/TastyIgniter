<?php
$isLogged = AdminAuth::isLogged();
?>
<?php if ($isLogged) {?>
    <nav class="navbar navbar-top navbar-expand" role="navigation">
        <div class="container-fluid">
            <div class="page-title">
                <span><?=Template::getHeading();?></span>
            </div>

            <div class="navbar">
                <?=$this->widgets['mainmenu']->render();?>

                <button
                    type="button"
                    class="navbar-toggler"
                    data-toggle="collapse"
                    data-target="#navSidebar"
                    aria-controls="navSidebar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="fa fa-bars"></span>
                </button>
            </div>
        </div>
    </nav>
<?php }?>
