<div id="page-box" class="module-box">
    <div class="panel panel-default">
        <div class="list-group list-group-responsive">
            <?php foreach ($sidebarPageList as $page) { ?>
                <a
                    class="list-group-item <?= ($activePageId == $page->page_id) ? 'active' : ''; ?>"
                    href="<?= site_url('pages', ['slug' => $page->permalink_slug]); ?>"
                >
                    <i class="fa fa-angle-right"></i>
                    <?= $page->name; ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>