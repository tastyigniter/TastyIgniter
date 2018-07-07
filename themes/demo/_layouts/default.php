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
                <div class="col-sm-12">
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
    <script type="text/javascript" src="<?= asset('app/system/assets/ui/js/vendor/vendor.js'); ?>" id="vendor-js"></script>
    <script type="text/javascript" src="<?= asset('app/system/assets/ui/js/flashmessage.js'); ?>" id="flashmessage-js"></script>
    <script type="text/javascript" src="<?= asset('app/system/assets/ui/js/app.js'); ?>" id="app-js"></script>
    <?= get_script_tags(['ui', 'widget', 'component', 'custom', 'theme']); ?></body>
</html>