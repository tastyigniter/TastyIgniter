<div class="d-flex align-items-center">
    <div class="px-2">
        <i
            class="fa fa-asterisk <?= $item->isRequired() ? 'text-danger' : 'text-muted'; ?>"
            title="<?= $item->isRequired()
                ? lang('admin::lang.menu_options.is_required')
                : lang('admin::lang.menu_options.is_not_required'); ?>"
        ></i>
    </div>
    <div class="px-2">
        <?php if ($item->display_type == 'radio') { ?>
            <i
                title="<?= sprintf(lang('admin::lang.menu_options.text_option_summary'), $item->display_type) ?>"
                class="fa fa-dot-circle text-muted"
            ></i>
        <?php } elseif ($item->display_type == 'checkbox') { ?>
            <i
                title="<?= sprintf(lang('admin::lang.menu_options.text_option_summary'), $item->display_type) ?>"
                class="fa fa-check-square text-muted"
            ></i>
        <?php } elseif ($item->display_type == 'select') { ?>
            <i
                title="<?= sprintf(lang('admin::lang.menu_options.text_option_summary'), $item->display_type) ?>"
                class="fa fa-caret-square-down text-muted"
            ></i>
        <?php } elseif ($item->display_type == 'quantity') { ?>
            <i
                title="<?= sprintf(lang('admin::lang.menu_options.text_option_summary'), $item->display_type) ?>"
                class="fa fa-plus-square text-muted"
            ></i>
        <?php } else { ?>
            <?= sprintf(lang('admin::lang.menu_options.text_option_summary'), $item->display_type); ?>
        <?php } ?>
    </div>
    <div class="px-2">
        <p class="card-title font-weight-bold mb-1"><?= $item->option_name ?></p>
        <?php foreach ($item->menu_option_values->sortBy('priority')->take(10) as $menuOptionValue) { ?>
            <span class="badge border"><?= $menuOptionValue->name ?></span>
        <?php } ?>
    </div>
</div>