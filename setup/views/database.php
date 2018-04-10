<?php
$db = $setup->getDatabaseDetails();
?>
<div class="form-group">
    <label for="input-db-name" class="control-label"><?= lang('label_database'); ?></label>
    <input type="text"
           name="database"
           id="input-db-name"
           class="form-control"
           value="<?= $db->database; ?>"
           placeholder="<?= lang('help_database'); ?>"/>
</div>
<div class="form-group">
    <label for="input-db-host" class="control-label"><?= lang('label_hostname'); ?></label>
    <input type="text"
           name="host"
           id="input-db-host"
           class="form-control"
           value="<?= $db->host; ?>"
           placeholder="<?= lang('help_hostname'); ?>"/>
</div>
<div class="form-group">
    <label for="input-db-port" class="control-label"><?= lang('label_port'); ?></label>
    <input type="text"
           name="port"
           id="input-db-port"
           class="form-control"
           value="<?= $db->port; ?>"/>
</div>
<div class="form-group">
    <label for="input-db-user" class="control-label"><?= lang('label_username'); ?></label>
    <input type="text"
           name="username"
           id="input-db-user"
           class="form-control"
           value="<?= $db->username; ?>"
           placeholder="<?= lang('help_username'); ?>"/>
</div>
<div class="form-group">
    <label for="input-db-pass" class="control-label"><?= lang('label_password'); ?></label>
    <input type="password"
           name="password"
           id="input-db-pass"
           class="form-control"
           value="<?= $db->password; ?>"
           placeholder="<?= lang('help_password'); ?>"/>
</div>
<div class="form-group">
    <label for="input-db-prefix" class="control-label"><?= lang('label_prefix'); ?></label>
    <input type="text"
           name="prefix"
           id="input-db-prefix"
           class="form-control"
           value="<?= $db->prefix; ?>"
           placeholder="<?= lang('help_dbprefix'); ?>"/>
</div>

<input type="hidden" name="disableLog" value="1">
<div class="buttons">
    <a class="btn btn-default" href=""><?= lang('button_back'); ?></a>
    <button type="submit" class="btn btn-success pull-right"><?= lang('button_admin'); ?></button>
</div>
