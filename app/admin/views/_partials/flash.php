<?php foreach (Flash::all() as $message) { ?>
    <?php if ($message['overlay']) { ?>
        <?= $this->makePartial('flash_modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message'],
        ]); ?>
    <?php }
    else { ?>
        <div class="alert alert-<?= $message['level']; ?> <?= $message['important'] ? 'alert-important' : ''; ?>"
             role="alert"
        >
            <?php if ($message['important']) { ?>
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            <?php } ?>
            <?= $message['message']; ?>
        </div>
    <?php } ?>
<?php } ?>

<?php if ($messages = session('errors', collect())->all()) { ?>
    <div class="alert alert-danger"
         role="button"
         data-toggle="collapse"
         href="#collapseErrors"
         aria-expanded="false"
         aria-controls="collapseErrors">
        <i class="fa fa-angle-down"></i>
        <b><?= lang('admin::default.alert_form_error_message') ?></b>
    </div>

    <div class="collapse" id="collapseErrors">
        <?php foreach ($messages as $message) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $message; ?>
            </div>
        <?php } ?>
    </div>
    <?php session()->forget('errors'); ?>
<?php } ?>
