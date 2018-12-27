<span class="card-title font-weight-bold mb-0"><?= $item->option_name ?></span>
<p class="card-text mb-0 text-muted">
    <?= sprintf(lang('admin::lang.menu_options.text_option_summary'),
        sprintf('<b>%s</b>', $item->isRequired()
            ? lang('admin::lang.menu_options.is_required')
            : lang('admin::lang.menu_options.is_not_required')),
        sprintf('<b>%s</b>', $item->display_type)) ?>
</p>
<p class="card-text">
    <?php foreach ($item->menu_option_values->sortBy('priority')->take(10) as $menuOptionValue) { ?>
        <span class="badge badge-secondary"><?= $menuOptionValue->name ?></span>
    <?php } ?>
</p>
