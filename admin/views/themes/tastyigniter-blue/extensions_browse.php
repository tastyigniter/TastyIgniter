<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>" enctype="multipart/form-data">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h4><?php echo lang('text_browse_title'); ?></h4>
                </div>
            </div>
         </form>
    </div>
</div>
<?php echo get_footer(); ?>