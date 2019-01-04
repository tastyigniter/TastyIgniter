<?php foreach (Flash::all() as $message) { ?>
    <?php if ($message['overlay']) { ?>
        <div
            data-control="flash-overlay"
            data-title="<?= array_get($message, 'title') ?>"
            data-text="<?= array_get($message, 'message') ?>"
            data-icon="<?= $message['level']; ?>"
            data-close-on-click-outside="<?= $message['important'] ? 'false' : 'true'; ?>"
            data-close-on-esc="<?= $message['important'] ? 'false' : 'true'; ?>"
        ></div>
    <?php }
    else { ?>
        <div
            class="alert alert-<?= $message['level']; ?><?= $message['important'] ? ' alert-important' : ''; ?>"
            data-control="flash-message"
            data-allow-dismiss="<?= $message['important'] ? 'false' : 'true'; ?>"
            role="alert"
        ><?= $message['message']; ?></div>
    <?php } ?>
<?php } ?>

<?php if (AdminAuth::isLogged()) { ?>
    <?php if ($messages = session('admin_errors', collect())->all()) { ?>
        <div
            class="alert alert-danger"
            data-control="flash-message"
            data-allow-dismiss="false"
            role="alert"
        >
            <b><?= lang('admin::lang.alert_form_error_message') ?></b>
            <?php foreach ($messages as $message) { ?>
                <p><?= $message; ?></p>
            <?php } ?>
        </div>
        <?php session()->forget('admin_errors'); ?>
    <?php } ?>
<?php } ?>
