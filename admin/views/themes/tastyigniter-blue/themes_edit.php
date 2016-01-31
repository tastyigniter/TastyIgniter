<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<?php if ($is_customizable) { ?>
                    <li class="active"><a href="#customize" data-toggle="tab"><?php echo lang('text_tab_customize'); ?></a></li>
				<?php } ?>
				<li class="<?php echo ($is_customizable) ?: 'active'; ?>">
					<?php if (!empty($file)) { ?>
						<a class="pull-left" href="#edit-source" data-toggle="tab"><?php echo lang('text_tab_edit_source'); ?></a>
						<a class="pull-right" href="<?php echo $close_file; ?>"><i class="fa fa-times-circle text-danger"></i></a>
					<?php } else { ?>
						<a href="#edit-source" data-toggle="tab"><?php echo lang('text_tab_edit_source'); ?></a>
					<?php } ?>
				</li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<?php if ($is_customizable) { ?>
                    <div id="customize" class="tab-pane theme-sections clearfix active">
                        <div class="col-sm-2 wrap-none">
                            <?php echo $customizer_nav; ?>
                        </div>
                        <div class="col-sm-10 wrap-veritcal border-left">
                            <div class="tab-content">
                                <?php echo $customizer_sections; ?>
                             </div>
                        </div>
                    </div>
                <?php } ?>

				<div id="edit-source" class="tab-pane row theme-editor border-bottom <?php echo ($is_customizable) ? '' : 'active'; ?>">
					<?php if (!empty($file['heading'])) { ?>
						<h4 class="text-info editor-text"><?php echo $file['heading']; ?></h4>
					<?php } ?>

                    <div class="">
                        <div class="col-sm-9 wrap-none wrap-left">
                            <div class="theme-editor-holder">
                                <?php if (!empty($file['type']) AND $file['type'] === 'file') { ?>
                                    <textarea name="editor_area" id="editor-area"><?php echo $file['content']; ?></textarea>
                                <?php } else if (!empty($file['type']) AND $file['type'] === 'img') { ?>
                                    <div class="image-holder">
                                        <img class="center-block wrap-horizontal wrap-right" alt="<?php echo $file['name']; ?>" src="<?php echo $file['content']; ?>" style="max-width:100%" />
                                    </div>
                                <?php } else { ?>
                                    <div class="jumbotron">
                                        <?php echo lang('text_select_file_summary'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-3 wrap-none wrap-right">
                            <div class="metisHolder border-right">
                                <?php echo $theme_files; ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php if (!empty($file)) { ?>
		$('#nav-tabs a[href="#edit-source"]').tab('show');
	<?php } else { ?>
		$('#nav-tabs a[href="#customize"]').tab('show');
	<?php } ?>

    if ($('#editor-area').val()) {
        var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor-area'), {
            lineNumbers: true,
            mode: "<?php echo $mode; ?>"
        });
    }

    $('.ti-color-picker').colorpicker();

	$('.metisFolder').metisMenu({
		toggle: false
	});
});
//--></script>
<script type="text/javascript"><!--
$(function  () {
	// Set the popover default content
	$('.image-preview .input-group-addon').popover({
		trigger:'manual',
		html:true,
		title: "Preview",
		content: "There's no image",
		placement:'bottom'
	});

	// Create the preview image
	$(".image-preview .input-group-addon").hover(function () {
		var img = $('<img/>', {
			id: 'dynamic',
			width:250,
			height:200
		});

		img.attr('src', $(this).parent().find('img').attr('src'));
		$(this).attr("data-trigger", "hover");
		$(this).attr("data-content", $(img)[0].outerHTML).popover("toggle");
	});

	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="4"></td></tr>',
		handle: '.handle'
	})
})
//--></script>
<?php echo get_footer(); ?>