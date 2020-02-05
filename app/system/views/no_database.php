<!DOCTYPE html>
<html lang="<?= App::getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Lang::get('system::lang.no_database.label') ?></title>
    <link rel="shortcut icon" href="<?= asset('app/admin/assets/images/favicon.ico'); ?>" type="image/ico">
    <link href="<?= asset('app/admin/assets/css/static.css'); ?>" rel="stylesheet">
</head>
<body>
<article>
    <h2><?= Lang::get('system::lang.no_database.label') ?></h2>
    <p class="lead"><?= Lang::get('system::lang.no_database.help') ?></p>
</article>
</body>
</html>