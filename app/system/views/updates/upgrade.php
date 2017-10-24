<?= Assets::getDocType() ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?= Assets::getMetas() ?>
    <title><?= lang('system::updates.text_title'); ?></title>
    <?= Assets::getCss() ?>
    <?= Assets::getJs() ?>
    <style>
        html, body {
            height: auto;
        }
        body {
            background-color: #ECF0F5;
        }
        .fa {
            color: #999;
        }
    </style>
    <script type="text/javascript">
        var js_site_url = function (str) {
            var strTmp = "<?= admin_url('" + str + "'); ?>"
            return strTmp
        }

        var js_base_url = function (str) {
            var strTmp = "<?= url('" + str + "'); ?>"
            return strTmp
        }
    </script>
</head>
<body>
<p><?= lang('text_update_start'); ?></p>
