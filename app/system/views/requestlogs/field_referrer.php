<?php if ($formModel->referrer AND count($formModel->referrer)) { ?>
    <div class="form-control-static">
        <ul class="list-unstyled">
            <?php foreach ($formModel->referrer as $referrer) { ?>
                <li><?= e($referrer) ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <div class="form-control-static"><?= lang('system::lang.request_logs.text_empty_referrer') ?></div>
<?php } ?>