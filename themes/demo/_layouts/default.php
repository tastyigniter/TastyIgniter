---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= App::getLocale(); ?>">
<head>
    <?= partial('head'); ?>
</head>
<body class="<?= $this->page->bodyClass; ?>">
    <header id="main-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <button
                        type="button"
                        class="btn-navbar navbar-toggle"
                        data-toggle="collapse"
                        data-target="#main-header-menu-collapse"
                    ><i class="fa fa-align-justify"></i></button>

                    <div class="logo">
                        <a class="" href="<?= page_url('home'); ?>"><?= $this->page->title ?></a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div id="page-wrapper" class="content-area">
        <?= page(); ?>
    </div>

    <footer id="page-footer">
        <?= partial('footer'); ?>
    </footer>
    <script type="text/javascript" src="<?= assets_url('js/app/vendor.js') ?>" id="vendor-js"></script>
    <script type="text/javascript" src="<?= assets_url('js/app/flashmessage.js') ?>" id="flashmessage-js"></script>
    <script type="text/javascript" src="<?= assets_url('js/app/app.js') ?>" id="app-js"></script>
    <?= get_script_tags(['ui', 'widget', 'component', 'custom', 'theme']); ?></body>
</html>