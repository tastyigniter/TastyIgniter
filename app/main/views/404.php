<!DOCTYPE html>
<html lang="<?= App::getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <title><?= Lang::get('main::lang.not_found.page_label') ?></title>
</head>
<body>
    <div id="container">
        <h1><?= Lang::get('main::lang.not_found.page_label') ?></h1>
        <p class="lead"><?= Lang::get('main::lang.not_found.page_message') ?></p>
    </div>
</body>
</html>