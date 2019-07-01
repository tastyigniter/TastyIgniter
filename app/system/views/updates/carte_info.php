<?php if (isset($carteInfo['owner'])) { ?>
    <div class="panel-body border-bottom">
        <div class="d-flex">
            <div class="media-right media-middle">
                <i class="fa fa-globe fa-3x"></i>
            </div>
            <div class="media-body wrap-left">
                <h3 class="no-margin-top"><?= $carteInfo['name']; ?></h3>
                <p><?= $carteInfo['description'] ?? ''; ?></p>
                <strong>Owner:</strong> <?= $carteInfo['owner']; ?><br/>
                <span class="small">
                    <strong>Updated:</strong> <?= mdate(setting('date_format').' '.setting('time_format'), strtotime($carteInfo['updated_at'])); ?>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
