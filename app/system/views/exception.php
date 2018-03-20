<!doctype html>
<html lang="<?= App::getLocale(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exception</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
    <p class="lead">We're sorry, but an unhandled error occurred. Please see the details below.</p>
    <p><?= $exception->getMessage(); ?></p>
</body>
</html>