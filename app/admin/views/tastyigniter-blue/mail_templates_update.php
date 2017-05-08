<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#changes" data-toggle="tab"><?php echo lang('text_tab_changes'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="changes" class="tab-pane active">
                    <?php if ($changes) { ?>
                    <div class="panel panel-default panel-table">
                    <?php foreach ($changes as $key => $templates) { ?>
                        <?php if (is_array($templates)) { ?>
                        <div class="panel-heading">
                            <h4><?php echo lang("text_{$key}_changes"); ?></h4>
                        </div>
                        <?php } ?>

                        <div class="table-responsive">
                        <table border="0" class="table table-striped table-border table-no-spacing table-templates">
                            <tbody id="accordion">
                            <?php $template_row = 1; ?>
                            <?php if (is_array($templates)) { ?>
                            <?php foreach ($templates as $template) { ?>
                                <tr data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="template-row-<?php echo $template['template_data_id']; ?>" data-target="#template-row-<?php echo $template['template_data_id']; ?>">
                                    <td class="action action-one">
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" class="styled" id="checkbox-<?php echo $template['template_data_id']; ?>" value="<?php echo $template['template_data_id']; ?>" name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][update]" />
                                            <label for="checkbox-<?php echo $template['template_data_id']; ?>"></label>
                                        </div>
                                    </td>
                                    <td class="left"><b><?php echo $template['code']; ?></b> - <?php echo $template['title']; ?></td>
                                    <td class="text-right"><?php echo $template['date_updated']; ?></td>
                                    <td class="text-right"><?php echo $template['date_added']; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <div id="template-row-<?php echo $template['template_data_id']; ?>" class="collapse">
                                            <div class="template-content">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label for="input-subject" class="control-label"><?php echo lang('label_subject'); ?></label>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <input type="hidden" name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][template_id]" value="<?php echo set_value('templates['.$template['template_data_id'].'][template_id]', $template['template_id']); ?>" />
                                                        <input type="hidden" name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][code]" value="<?php echo set_value('templates['.$template['template_data_id'].'][code]', $template['code']); ?>" />
                                                        <input type="hidden" name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][label]" value="<?php echo set_value('templates['.$template['template_data_id'].'][label]', $template['label']); ?>" />
                                                        <input type="text" name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][subject]" id="input-subject" class="form-control" value="<?php echo set_value('templates['.$template['template_data_id'].'][subject]', $template['subject']); ?>" readonly />
                                                        <?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div id="input-wysiwyg" class="col-md-12">
                                                        <textarea
                                                            name="changes[<?php echo $key ?>][<?php echo $template['template_data_id']; ?>][body]"
                                                            style="height:300px;width:100%;" class="form-control" readonly>
                                                            <?php echo set_value('templates['.$template['template_data_id'].'][body]', $template['body']); ?>
                                                        </textarea>
                                                        <?php echo form_error('templates['.$template['template_data_id'].'][body]', '<span class="text-danger">', '</span>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $template_row++; ?>
                            <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    <?php } ?>
                    </div>
                    <?php } else { ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><?php echo lang('text_no_changes'); ?></p>
                            </div>
                        </div>
                    <?php } ?>
				</div>
			</div>
		</form>

		<div class="mail-variable-container"></div>
	</div>
</div>
<script type="text/javascript">
	$('textarea').summernote({
		height: 300,
	});
</script>
<?php echo get_footer(); ?>