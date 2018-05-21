<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'     => 'list-form',
            'role'   => 'form',
            'method' => 'POST',
        ]
    ); ?>

    <?= $this->widgets['toolbar']->render() ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="10%">Level</th>
                <th width="15%">Date</th>
                <th>Content</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($logs as $key => $log) { ?>
                <tr>
                    <td class="text-<?= e($log['class']); ?>">
                        <span
                            class="fa fa-<?= e($log['icon']); ?>"
                            aria-hidden="true"
                        ></span>&nbsp;&nbsp;<?= $log['level']; ?>
                    </td>
                    <td class="date"><?= date('Y-m-d H:i:s', strtotime($log['date'])); ?></td>
                    <td
                        class="text"
                        <?php if ($log['stack']) { ?>
                            role="button"
                            data-toggle="collapse"
                            data-target="#stack-<?= e($key); ?>"
                            aria-expanded="false"
                            aria-controls="stack<?= e($key); ?>"
                        <?php } ?>
                    >
                        <?= e($log['text']); ?>

                        <?php if (isset($log['summary'])) { ?>
                            <br/><?= e($log['summary']); ?>
                        <?php } ?>

                        <?php if ($log['stack']) { ?>
                            <div class="collapse" id="stack-<?= e($key); ?>">
                                <?= nl2br(trim($log['stack'])); ?>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <?= form_close(); ?>
</div>
