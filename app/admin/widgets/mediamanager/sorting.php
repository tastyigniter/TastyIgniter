<?php
$sortName = isset($sortBy[0]) ? $sortBy[0] : null;
$sortDirection = isset($sortBy[1]) ? $sortBy[1] : 'ascending';
$sortIcon = ($sortDirection === 'ascending') ? '-up' : '-down';

?>
<ul class="dropdown-menu" role="menu">
    <li><span><strong><?= lang('text_sort_by'); ?>:</strong></span></li>
    <li class="divider"></li>
    <li class="<?= ($sortName == 'name') ? 'active' : ''; ?>">
        <a data-media-sort="name"><?= lang('label_name'); ?></a>
    </li>
    <li class="<?= ($sortName == 'date') ? 'active' : ''; ?>">
        <a data-media-sort="date"><?= lang('label_date'); ?></a>
    </li>
    <li class="<?= ($sortName == 'size') ? 'active' : ''; ?>">
        <a data-media-sort="size"><?= lang('label_size'); ?></a>
    </li>
    <li class="<?= ($sortName == 'extension') ? 'active' : ''; ?>">
        <a data-media-sort="extension"><?= lang('label_type'); ?></a>
    </li>
</ul>
