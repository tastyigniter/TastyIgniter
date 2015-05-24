<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<?php if ($is_customizable) { ?>
                    <li class="active"><a href="#customize" data-toggle="tab">Customize</a></li>
                    <li><a href="#edit-source" data-toggle="tab">Edit Source</a></li>
                <?php } else { ?>
                    <li class="active"><a href="#edit-source" data-toggle="tab">Edit Source</a></li>
                <?php } ?>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<?php if ($is_customizable) { ?>
                    <div id="customize" class="tab-pane theme-sections clearfix active">
                        <div class="col-sm-2 wrap-none">
                            <?php echo $customizer_nav; ?>
                        </div>
                        <div class="col-sm-10 wrap-veritcal">
                            <div class="tab-content">
                                <?php echo $customizer_sections; ?>
                             </div>
                        </div>
                    </div>
                <?php } ?>

				<div id="edit-source" class="tab-pane row theme-editor <?php echo ($is_customizable) ? '' : 'active'; ?>">
					<?php if (!empty($file['heading'])) { ?>
						<h4 class="text-info editor-text"><?php echo $file['heading']; ?></h4>
					<?php } ?>

                    <div class="">
                        <div class="col-sm-9 wrap-none wrap-left">
                            <!--<a class="theme-tree-toggle"><i class="fa fa-angle-double-left"></i></a>-->
                            <div class="theme-editor-holder">
                                <?php if (!empty($file['type']) AND $file['type'] === 'file') { ?>
                                    <textarea name="editor_area" id="editor-area" class="form-control" rows="28"><?php echo $file['content']; ?></textarea>
                                <?php } else if (!empty($file['type']) AND $file['type'] === 'img') { ?>
                                    <img class="center-block wrap-horizontal" alt="<?php echo $file['name']; ?>" src="<?php echo $file['content']; ?>" />
                                <?php } else { ?>
                                    <div class="jumbotron">
                                        <h4>Select a File!</h4>
                                        <p>You can select from a number of options to alter the look of your theme. The Theme Editor supports Source files, image files and font files.</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-3 wrap-none wrap-right">
                            <div class="metisHolder">
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
if ($('#editor-area').val()) {
	var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor-area'), {
    	lineNumbers: true,
    	mode: "<?php echo $mode; ?>"
  	});
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php if (!empty($file)) { ?>
		$('#nav-tabs a[href="#edit-source"]').tab('show');
	<?php } else { ?>
		$('#nav-tabs a[href="#customize"]').tab('show');
	<?php } ?>

	$('.ti-color-picker').colorpicker();

	$('.metisFolder').metisMenu({
		toggle: false
	});
});
//--></script>
<script type="text/javascript"><!--
$(function  () {
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