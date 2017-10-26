<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'   => 'edit-form',
            'role' => 'form',
        ],
        ['_method' => 'PATCH']
    ); ?>

    <div class="tab-heading">
        <ul id="nav-tabs" class="nav nav-tabs">
            <li class="active">
                <a href="#existing-backup"
                   data-toggle="tab"><?= lang('system::maintenance.text_tab_existing_backup'); ?></a></li>
            <li><a href="#create-backup"
                   data-toggle="tab"><?= lang('system::maintenance.text_tab_create_backup'); ?></a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="existing-backup" class="tab-pane active">
            <div class="panel-table">
                <?= $this->makePartial('maintenance/existing_backup') ?>
            </div>
        </div>

        <div id="create-backup" class="tab-pane">
            <div class="alert alert-info">
                <?= lang('system::maintenance.alert_info_memory_limit'); ?>
            </div>
            <div class="panel panel-form">
                <?= $this->makePartial('maintenance/create_backup') ?>
            </div>
        </div>
    </div>

    <?= form_close(); ?>
    <?= $this->widgets['toolbar']->render() ?>
</div>
