<?php

use Main\Classes\ThemeManager;

$themeManager = ThemeManager::instance();
$themeCode = $formModel->code;
$themeFiles = $themeManager->listFiles($themeCode);
$themeFilesTree = $themeManager->buildFilesTree($themeFiles, page_url().'?file={link}', '');

$themeFilename = get('file');
$themeFile = $themeManager->readFile($themeFilename, $themeCode);

$editorMode = 'javascript';
if (isset($themeFile['ext'])) {
    if ($themeFile['ext'] == 'php') {
        $editorMode = 'application/x-httpd-php';
    }
    else if ($themeFile['ext'] == 'css') {
        $editorMode = 'css';
    }
}

?>
<?php if ($themeFile) { ?>
    <h4 class="text-info editor-text">
        <?= sprintf(lang(($themeFile['type'] == 'img') ? 'system::themes.text_viewing' : 'system::themes.text_editing'), $themeFilename, $themeCode); ?>
    </h4>
<?php } ?>

<div class="row">
    <div class="col-sm-9 wrap-none wrap-left">
        <div class="theme-editor-holder">
            <?php if ($themeFile) { ?>
                <?php if ($themeFile['type'] == 'img') { ?>
                    <div class="image-holder">
                        <img
                            class="center-block wrap-horizontal wrap-right"
                            alt="<?= $themeFile['name']; ?>"
                            src="<?= $themeFile['content']; ?>"
                            style="max-width:100%"
                        />
                    </div>
                <?php }
                else { ?>
                    <textarea
                        name="<?= $field->getName(); ?>"
                        id="editor-area"
                    ><?= strlen($field->value) ? $field->value : trim($themeFile['content']); ?></textarea>
                <?php } ?>
            <?php }
            else { ?>
                <div class="jumbotron">
                    <?= lang('system::themes.text_select_file_summary'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-3 wrap-none wrap-right">
        <div class="metisHolder border-right">
            <?= $themeFilesTree; ?>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $(document).ready(function () {

        if ($('textarea#editor-area').val()) {
            CodeMirror.fromTextArea(document.getElementById('editor-area'), {
                lineNumbers: true,
                theme: 'material',
                mode: "<?= $editorMode; ?>"
            })
        }

        $('.metisFolder').metisMenu({
            toggle: false
        })
    })
    //--></script>
