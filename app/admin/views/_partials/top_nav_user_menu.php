<?php
$staffName = AdminAuth::getStaffName();
$staffEmail = AdminAuth::getStaffEmail();
$staffAvatar = md5(strtolower(trim($staffEmail)));
$staffGroupName = AdminAuth::staffGroupName();
$staffLocation = AdminAuth::getLocationName();
$staffEditLink = admin_url('staffs/edit/'.AdminAuth::getStaffId());
$logoutLink = admin_url('logout');
?>
<li class="menu-link dropdown">
    <span class="dropdown-toggle" data-toggle="dropdown">
        <img class="img-rounded" src="<?= '//www.gravatar.com/avatar/'.$staffAvatar.'.png?s=64&d=mm'; ?>">
    </span>
    <ul class="dropdown-menu">
        <li>
            <div class="wrap-vertical">
                <div class="wrap-top wrap-vertical">
                    <p class="small text-uppercase"><?= $staffGroupName; ?></p>
                    <h5><strong><?= $staffName; ?></strong></h5>
                    <p class="small">
                        <i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?= $staffLocation; ?>
                    </p>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <a href="<?= $staffEditLink; ?>">
                <i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::default.text_edit_details'); ?>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a class="list-group-item-danger" href="<?= $logoutLink; ?>">
                <i class="fa fa-power-off fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::default.text_logout'); ?>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="https://tastyigniter.com/about/" target="_blank">
                <i class="fa fa-info-circle fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::default.text_about_tastyigniter'); ?>
            </a>
        </li>
        <li>
            <a href="https://docs.tastyigniter.com" target="_blank">
                <i class="fa fa-book fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::default.text_documentation'); ?>
            </a>
        </li>
        <li>
            <a href="https://forum.tastyigniter.com" target="_blank">
                <i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::default.text_community_support'); ?>
            </a>
        </li>
        <li class="menu-footer"></li>
    </ul>
</li>
