<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <?php if (!empty($lang_file)) { ?>
                    <li><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
                    <li><a href="#files" data-toggle="tab"><?php echo lang('text_tab_files'); ?></a></li>
                    <li class="active"><a class="pull-left" href="#edit-lang-values" data-toggle="tab"><?php echo lang('text_tab_edit_file'); ?>: <?php echo $lang_file; ?></a><a class="pull-right" href="<?php echo $close_edit_link; ?>"><i class="fa fa-times-circle text-danger"></i></i></a></li>
                <?php } else if (!empty($lang_files)) { ?>
                    <li><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
                    <li class="active"><a href="#files" data-toggle="tab"><?php echo lang('text_tab_files'); ?></a></li>
                <?php } else { ?>
                    <li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
            <div class="tab-content">
                <div id="general" class="tab-pane row wrap-all <?php echo (!empty($lang_files)) ? '' : 'active'?>">
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>

                        <div class="col-sm-5">
                            <input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>"/>
                            <?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-code" class="col-sm-3 control-label"><?php echo lang('label_code'); ?>
                            <span class="help-block"><?php echo lang('help_language'); ?></span>
                        </label>

                        <div class="col-sm-5">
                            <input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>"/>
                            <?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-image" class="col-sm-3 control-label"><?php echo lang('label_image'); ?></label>

                        <div class="col-sm-5">
                            <div class="input-group">
                            <span class="input-group-addon lg-addon" title="<?php echo $image['name']; ?>">
                                <i><img class="thumb img-responsive" id="input-image-thumb" width="24px" src="<?php echo $image['path']; ?>"></i>
                            </span>
                                <input type="text" class="form-control" id="input-image" value="<?php echo set_value('image', $image['input']); ?>" name="image">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" onclick="mediaManager('input-image');" type="button">
                                    <i class="fa fa-picture-o"></i></button>
                                <button class="btn btn-danger" onclick="$('#input-image-thumb').attr('src', '<?php echo $no_photo; ?>'); $('#input-image').attr('value', '');" type="button">
                                    <i class="fa fa-times-circle"></i></button>
                            </span>
                            </div>
                            <?php echo form_error('image', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-idiom" class="col-sm-3 control-label"><?php echo lang('label_idiom'); ?>
                            <span class="help-block"><?php echo lang('help_idiom'); ?></span>
                        </label>

                        <div class="col-sm-5">
                            <input type="text" name="idiom" id="input-idiom" class="form-control" value="<?php echo set_value('idiom', $idiom); ?>"/>
                            <?php echo form_error('idiom', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <?php if (empty($lang_files)) { ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo lang('label_clone'); ?></label>

                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-default active"><input type="radio" name="clone_language" value="0" <?php echo set_radio('clone_language', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-default"><input type="radio" name="clone_language" value="1" <?php echo set_radio('clone_language', '1'); ?>><?php echo lang('text_yes'); ?></label>
                                </div>
                                <?php echo form_error('clone_language', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group" id="language-to-clone">
                            <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_language'); ?></label>
                            <div class="col-sm-5">
                                <select name="language_to_clone" id="" class="form-control">
                                    <?php foreach ($languages as $language) { ?>
                                        <option value="<?php echo $language['idiom']; ?>" <?php echo set_select('language_to_clone', $language['idiom']); ?> ><?php echo $language['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('language_to_clone', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo lang('label_can_delete'); ?></label>

                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($can_delete === '1') { ?>
                                    <label class="btn btn-default active"><input type="radio" name="can_delete" value="1" <?php echo set_radio('can_delete', '1', TRUE); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-default"><input type="radio" name="can_delete" value="0" <?php echo set_radio('can_delete', '0'); ?>><?php echo lang('text_yes'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-default"><input type="radio" name="can_delete" value="1" <?php echo set_radio('can_delete', '1'); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-default active"><input type="radio" name="can_delete" value="0" <?php echo set_radio('can_delete', '0', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('can_delete', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>

                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($status == '1') { ?>
                                    <label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>

                <div id="files" class="tab-pane row wrap-all <?php echo (!empty($lang_files) AND empty($lang_file)) ? 'active' : ''?>">
                    <?php if (!empty($lang_file)) { ?>
                        <div class="alert alert-warning">
                            <p><?php echo lang('alert_save_changes'); ?></p>
                        </div>
                    <?php } ?>
                    <?php foreach ($lang_files as $type => $files) { ?>
                        <h4 class="text-capitalize"><?php echo $type; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span class="small text-lowercase"><small><?php echo count($files); ?> <?php echo lang('text_files'); ?></small></span></h4>

                        <div class="row">
                            <?php foreach ($files as $file) { ?>
                                <div class="col-sm-4 wrap-bottom">
                                    <a href="<?php echo $file['edit']; ?>"><?php echo $file['name']; ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div id="edit-lang-values" class="tab-pane row wrap-all <?php echo (!empty($lang_file)) ? 'active': ''?>">
                    <div class="table-responsive">
                        <table class="table table-striped table-border table-no-spacing">
                            <thead>
                                <tr>
                                    <th class="text-right" width="30%"><?php echo lang('column_variable'); ?></th>
                                    <th width="70%"><?php echo lang('column_language'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lang_file_values)) { ?>
                                    <?php foreach ($lang_file_values as $key => $value) { ?>
                                        <tr>
                                            <td class="text-right"><?php echo $key; ?></td>
                                            <td><textarea class="form-control" name="lang[<?php echo $key; ?>]"><?php echo set_value("lang[{$key}]", $value); ?></textarea></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('input[name="clone_language"]').on('change', function () {
        $('#language-to-clone').fadeOut();

        if ($(this).val() == '1') {
            $('#language-to-clone').fadeIn();
        }
    });
});
//--></script>
<?php echo get_footer(); ?>