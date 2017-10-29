<?php if (get_theme_options('display_crumbs') == '1' AND ($breadcrumbs = get_breadcrumbs()) !== '') { ?>
    <div id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <?= $breadcrumbs; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
