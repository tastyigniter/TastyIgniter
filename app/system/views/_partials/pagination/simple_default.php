<?php if ($paginator->hasPages()) { ?>
    <ul class="pagination">
        <?php if ($paginator->onFirstPage()) { ?>
            <li class="disabled"><span><?= lang('pagination.previous') ?></span></li>
        <?php }
        else { ?>
            <li><a href="<?= $paginator->previousPageUrl() ?>" rel="prev"><?= lang('pagination.previous') ?></a></li>
        <?php } ?>

        <?php if ($paginator->hasMorePages()) { ?>
            <li><a href="<?= $paginator->nextPageUrl() ?>" rel="next"><?= lang('pagination.next') ?></a></li>
        <?php }
        else { ?>
            <li class="disabled"><span><?= lang('pagination.next') ?></span></li>
        <?php } ?>
    </ul>
<?php } ?>
