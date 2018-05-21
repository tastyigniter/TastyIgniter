<div id="requirements">
    <div>
        <div
            data-requirement data-code="php"
            data-label="<?= lang('label_php_version'); ?>"
            data-hint="<?= lang('text_php_version'); ?>"
        ></div>
        <div
            data-requirement data-code="mysqli"
            data-label="<?= lang('label_mysqli'); ?>"
            data-hint="<?= lang('text_mysqli_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="pdo"
            data-label="<?= lang('label_pdo'); ?>"
            data-hint="<?= lang('text_pdo_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="curl"
            data-label="<?= lang('label_curl'); ?>"
            data-hint="<?= lang('text_curl_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="connection"
            data-label="<?= lang('label_connection'); ?>"
            data-hint="<?= lang('text_live_connection'); ?>"
        ></div>
        <div
            data-requirement data-code="mbstring"
            data-label="<?= lang('label_mbstring'); ?>"
            data-hint="<?= lang('text_mbstring_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="ssl"
            data-label="<?= lang('label_ssl'); ?>"
            data-hint="<?= lang('text_ssl_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="gd"
            data-label="<?= lang('label_gd'); ?>"
            data-hint="<?= lang('text_gd_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="zip"
            data-label="<?= lang('label_zip'); ?>"
            data-hint="<?= lang('text_zip_installed'); ?>"
        ></div>
        <div
            data-requirement data-code="writable"
            data-label="<?= lang('label_writable'); ?>"
            data-hint="<?= lang('text_is_file_writable'); ?>"
        ></div>
    </div>

    <div class="list-group list-requirement"></div>
</div>

<div id="requirement-check-result"></div>
