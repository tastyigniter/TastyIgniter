<?php if ($showPagination) { ?>
    <nav class="pagination-bar d-flex justify-content-end">
        <?php if ($showPageNumbers) { ?>
            <div class="align-self-center">
                <?= sprintf(lang('admin::lang.list.text_showing'), $records->firstItem(), $records->lastItem(), $records->total()) ?>
            </div>
        <?php } ?>
        <div class="pl-3">
            <?= $records->render(); ?>
        </div>
    </nav>
<?php } ?>
