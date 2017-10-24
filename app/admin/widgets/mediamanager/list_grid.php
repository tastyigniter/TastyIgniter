<div class="media-list row">
    <?php $index=0; foreach ($items as $item) { ?>
        <?php $index++; ?>
        <div class="media-item col-xs-2">
            <div class="media-thumb"
                 data-media-item
                 data-media-item-name="<?= $item['name']; ?>"
                 data-media-item-type="<?= $item['type']; ?>"
                 data-media-item-path="<?= $item['path']; ?>"
                 data-media-item-size="<?= $item['size']; ?>"
                 data-media-item-modified="<?= $item['date']; ?>"
                 data-media-item-url="<?= $item['url']; ?>"
                 data-media-item-dimension="<?= isset($item['thumb']['dimension']) ? $item['thumb']['dimension'] : '--'; ?>"
                 data-media-item-folder="<?= $currentFolder; ?>"
                 data-media-item-data="<?= e(json_encode($item)); ?>"
                 <?php if ($item['name'] == $selectItem OR $index == 0) { ?>data-media-item-marked=""<?php } ?>
            >
                <a>
                    <img
                        alt="<?= $item['name']; ?>" class="img-responsive"
                        src="<?= isset($item['thumb']['url']) ? $item['thumb']['url'] : $item['url']; ?>"/>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
