<?php
$sortName = isset($sortBy[0]) ? $sortBy[0] : null;
$sortDirection = isset($sortBy[1]) ? $sortBy[1] : 'ascending';
$sortIcon = ($sortDirection === 'ascending') ? '-up' : '-down';

?>
<div class="dropdown-menu" role="menu">
    <h6 class="dropdown-header"><?= lang('main::lang.media_manager.text_sort_by'); ?></h6>
    <div class="dropdown-divider"></div>
    <a
        class="dropdown-item <?= ($sortName == 'name') ? 'active' : ''; ?>"
        data-media-sort="name"
    ><?= lang('main::lang.media_manager.label_name'); ?></a>
    <a
        class="dropdown-item <?= ($sortName == 'date') ? 'active' : ''; ?>"
        data-media-sort="date"
    ><?= lang('main::lang.media_manager.label_date'); ?></a>
    <a
        class="dropdown-item <?= ($sortName == 'size') ? 'active' : ''; ?>"
        data-media-sort="size"
    ><?= lang('main::lang.media_manager.label_size'); ?></a>
    <a
        class="dropdown-item <?= ($sortName == 'extension') ? 'active' : ''; ?>"
        data-media-sort="extension"
    ><?= lang('main::lang.media_manager.label_type'); ?></a>
</div>
