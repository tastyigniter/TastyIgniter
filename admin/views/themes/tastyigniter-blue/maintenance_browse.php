<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#database-browse" data-toggle="tab"><?php echo $sql_query; ?></a></li>
			</ul>
		</div>

        <div class="tab-content">
            <div id="backup" class="tab-pane row wrap-all active">
                <div class="panel panel-default panel-table">
                    <?php if (!empty($query_table)) { ?>
                        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo site_url('maintenance'); ?>">
                            <div class="table-responsive">
                                <?php echo $query_table; ?>
                            </div>
                        </form>

                        <div class="pagination-bar wrap-none wrap-top wrap-bottom">
                            <div class="links"><?php echo $pagination['links']; ?></div>
                            <div class="info"><?php echo $pagination['info']; ?></div>
                        </div>
                    <?php } else { ?>
                        <?php echo lang('text_no_row'); ?>
                    <?php }  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>