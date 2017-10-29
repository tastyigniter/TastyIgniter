---
title: main::account.inbox.text_heading
layout: default
permalink: /account/inbox

'[account]':
    context: user

'[accountInbox]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('account::sidebar'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountInbox'); ?>
            </div>
        </div>
    </div>
</div>
