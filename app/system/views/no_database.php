<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= Lang::get('system::lang.no_database.label') ?></title>
    <link href="<?= URL::to('/modules/system/assets/css/styles.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><i class="icon-database warning"></i> <?= Lang::get('system::lang.no_database.label') ?></h1>
        <p class="lead"><?= Lang::get('system::lang.no_database.help') ?></p>
    </div>
</body>
</html>
