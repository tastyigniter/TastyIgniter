---
title: Inbox
layout: default
permalink: /account/inbox

'[account]':
    security: customer

'[accountInbox]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountInbox'); ?>
            </div>
        </div>
    </div>
</div>
