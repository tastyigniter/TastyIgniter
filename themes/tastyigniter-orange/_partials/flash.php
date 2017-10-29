<?php foreach (Flash::all() as $message) { ?>
    <?php if ($message['overlay']) { ?>
        <div id="flash-overlay-modal" class="modal fade flash-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title"><?= $message['title'] ?></h4>
                    </div>

                    <div class="modal-body">
                        <p><?= $message['message'] ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>    <?php }
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
