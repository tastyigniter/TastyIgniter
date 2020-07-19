<!DOCTYPE html>
<html lang="<?= App::getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exception</title>
    <link rel="shortcut icon" href="<?= asset('app/admin/assets/images/favicon.ico'); ?>" type="image/ico">
    <link href="<?= asset('app/admin/assets/css/static.css'); ?>" rel="stylesheet">
</head>
<body>
<article>
    <h1>Exception</h1>
    <p class="lead">We're sorry, but an unhandled error occurred. Please see the details below.</p>
    <p><?= $exception->getMessage(); ?></p>
</article>
</body>
</html>