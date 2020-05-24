<?php $variables = $variables ?? $field->options(); ?>
<div class="w-100 flex-column<?= $variables ? ' form-fields pl-0' : ''; ?>">
    <label class="sr-only">
        <?= lang('system::lang.mail_templates.text_variables') ?>
    </label>
    <select
        class="form-control"
        autocomplete="off"
        onchange="$('#email-variables > div').hide();$('#'+this.value).show()"
    >
        <?php $index = 0; ?>
        <?php foreach ($variables as $groupName => $vars) { ?>
            <?php $index++; ?>
            <option
                value="<?= str_slug($groupName) ?>"
                <?= $index === 1 ? 'selected="selected"' : '' ?>
            ><?= e(lang($groupName)) ?></option>
        <?php } ?>
    </select>
    <div
        id="email-variables"
        class="card card-body bg-white mt-2"
    >
        <p class="small"><?= lang('system::lang.mail_templates.help_variables') ?></p>
        <?php $index = 0; ?>
        <?php foreach ($variables as $groupName => $vars) {
            $index++;
            $groupId = str_slug($groupName); ?>
            <div
                id="<?= $groupId; ?>"
                style="display: <?= $index === 1 ? 'block' : 'none' ?>;"
            >
                <?php foreach ($vars as $variable => $label) { ?>
                    <span
                        class="badge border mb-2"
                        title="<?= e(lang($label)); ?>"
                        style="font-size: 100%;"
                    ><pre class="mb-0 text-muted"><code><?= $variable; ?></code></pre></span>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>