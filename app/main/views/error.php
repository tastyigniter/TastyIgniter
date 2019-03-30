<!doctype html>
<html lang="<?= App::getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Error (500)</title>
    <link rel="shortcut icon" href="<?= asset('app/admin/assets/images/favicon.ico'); ?>" type="image/ico">
    <style>
        body { text-align: center; padding: 50px; }
        @media (min-width: 768px) {
            body { padding-top: 150px; }
        }
        h1 { font-size: 50px; }
        body { font: 20px -apple-system, BlinkMacSystemFont, Helvetica, sans-serif; color: #333; }
        article { display: block; width: 650px; margin: 0 auto; }
        a { color: #ED561A; text-decoration: none; }
        a:hover { color: #333; text-decoration: none; }
    </style>
</head>
<body>
<article>
    <p><?= lang('main::lang.alert_custom_error') ?></p>
</article>
</body>
</html>