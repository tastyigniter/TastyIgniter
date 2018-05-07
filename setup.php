<?php include_once 'setup/bootstrap.php';

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= sprintf(lang('text_title'), lang('text_installation')); ?></title>
    <link type="image/ico" rel="shortcut icon" href="favicon.ico">
    <link type="text/css" rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/css/vendor/animate.css">
    <link type="text/css" rel="stylesheet" href="assets/css/vendor/awesome-checkbox.css">
    <link type="text/css" rel="stylesheet" href="setup/assets/fonts.css">
    <link type="text/css" rel="stylesheet" href="setup/assets/stylesheet.css">
</head>
<body>
<div id="page">
    <div class="container">
        <div class="row">
            <div class="col-md-9 center-block">
                <div class="page-header">
                    <div class="row">
                        <div id="logo" class="col-xs-12 col-sm-4 navbar-right">
                            <div class="col-xs-8 col-sm-12">
                                <img src="assets/images/tastyigniter-logo.png" alt="TastyIgniter Logo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <h1 data-html="title"><?= lang('text_requirement_heading'); ?></h1>
                            <p data-html="subTitle"><?= lang('text_requirement_sub_heading'); ?></p>
                        </div>
                    </div>
                </div>

                <?php include_once 'setup/views/wizard.php'; ?>

                <div class="card">
                    <div class="content">

                        <form id="setup-form" accept-charset="utf-8" method="POST" role="form">
                            <div data-html="content"></div>
                            <input type="hidden" id="current-step" value="<?= $page->currentStep ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="progress-box">
    <div class="progress">
        <div
            class="progress-bar"
            role="progressbar"
            aria-valuenow="0"
            aria-valuemin="0"
            aria-valuemax="100"
            style="width:0%"></div>
    </div>
    <p class="message"></p>
</div>
<div id="flash-message"></div>

<footer class="footer-links">
    <ul class="list-group list-inline">
        <li><a target="_blank" href="//tastyigniter.com"><?= lang('text_tastyigniter_home'); ?></a></li>
        <li><a target="_blank" href="//docs.tastyigniter.com"><?= lang('text_documentation'); ?></a></li>
        <li><a target="_blank" href="//forum.tastyigniter.com"><?= lang('text_community_forums'); ?></a></li>
        <li>
            <a target="_blank" href="//forum.tastyigniter.com/forum-21.html"><?= lang('text_feature_request'); ?></a>
        </li>
    </ul>
</footer>

<?php
$viewsList = [
    'license',
    'check_alert',
    'requirements',
    'database',
    'settings',
    'install',
    'themes',
    'theme',
    'proceed',
];
?>

<?php foreach ($viewsList as $file) { ?>
    <script type="text/template" data-view="<?= $file ?>">
        <?php include VIEWPATH.'/'.$file.'.php'; ?>
    </script>
<?php } ?>

<script src="assets/js/app/vendor.js"></script>
<script src="assets/js/app/app.js"></script>
<script src="assets/js/vendor/mustache.js"></script>
<script src="assets/js/app/installer.js"></script>
<script type="text/javascript">
    Installer.Steps.requirement.view = "[data-view=\"requirements\"]"
    Installer.Steps.requirement.title = "<?= lang('text_requirement_heading'); ?>"
    Installer.Steps.requirement.subTitle = "<?= lang('text_requirement_sub_heading'); ?>"

    Installer.Steps.database.view = "[data-view=\"database\"]"
    Installer.Steps.database.title = "<?= lang('text_database_heading'); ?>"
    Installer.Steps.database.subTitle = "<?= lang('text_database_sub_heading'); ?>"

    Installer.Steps.settings.view = "[data-view=\"settings\"]"
    Installer.Steps.settings.title = "<?= lang('text_settings_heading'); ?>"
    Installer.Steps.settings.subTitle = "<?= lang('text_settings_sub_heading'); ?>"

    Installer.Steps.install.view = "[data-view=\"install\"]"
    Installer.Steps.install.title = "<?= lang('text_complete_heading'); ?>"
    Installer.Steps.install.subTitle = "<?= lang('text_complete_sub_heading'); ?>"

    Installer.Steps.proceed.view = "[data-view=\"proceed\"]"
    Installer.Steps.proceed.title = "Yippee!"
    Installer.Steps.proceed.subTitle = "Setup has been successfully completed"

    Installer.init()
</script>
</body>
</html>