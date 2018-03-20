---
title: Account Settings
layout: default
permalink: /account/settings

'[account]':
    security: customer
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= partial('account::settings'); ?>
            </div>
        </div>
    </div>
</div>
