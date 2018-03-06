---
description: Default layout
---
<?
function onInit()
{
}

function onStart()
{
}

function onEnd()
{
}

?>
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= App::getLocale(); ?>">
<head>
    <?= partial('head'); ?>
</head>
<body class="<?= $this->page->bodyClass; ?>">

    <?= partial('nav/menu'); ?>

    <div id="notification">
        <?= partial('flash'); ?>
    </div>

    <div id="page-wrapper" class="content-area">

        <?= partial('breadcrumb'); ?>

        <?php if ($page_heading = get_heading()) { ?>
            <?= partial('heading', ['heading' => $page_heading]); ?>
        <?php } ?>

        <?= page(); ?>

    </div>
    <footer id="page-footer">
        <?= partial('footer'); ?>
    </footer>
    <?= partial('scripts'); ?>
</body>
</html>