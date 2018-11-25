<?= form_open(current_url(),
    [
        'id' => 'list-form',
        'role' => 'form',
        'method' => 'POST',
    ]
); ?>

<div class="list-table table-responsive">
    <table class="table table-striped">
        <thead>
        <?= $this->makePartial('lists/list_head') ?>
        </thead>
        <tbody>
        <?php if (count($records)) { ?>
            <?= $this->makePartial('lists/list_body') ?>
        <?php }
        else { ?>
            <tr>
                <td colspan="<?= $columnTotal ?>"><?= $emptyMessage; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?= form_close(); ?>

<?= $this->makePartial('lists/list_pagination') ?>

<?php if ($showSetup) { ?>
    <?= $this->makePartial('lists/list_setup') ?>
<?php } ?>
