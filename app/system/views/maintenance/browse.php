<div class="row content">
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <li class="active"><a href="#database-browse" data-toggle="tab"><?= $sql_query; ?></a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="backup" class="tab-pane active">
                <div class="panel panel-default panel-table">
                    <?php if (!empty($query_table)) { ?>
                        <form role="form"
                              id="edit-form"
                              class="form-horizontal"
                              accept-charset="utf-8"
                              method="POST"
                              action="<?= admin_url('maintenance'); ?>">
                            <div class="table-responsive">
                                <?= $query_table; ?>
                            </div>
                        </form>

                        <div class="pagination-bar row">
                            <div class="links col-sm-8"><?= $pagination['links']; ?></div>
                            <div class="info col-sm-4"><?= $pagination['info']; ?></div>
                        </div>
                    <?php }
                    else { ?>
                        <?= lang('text_no_row'); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
