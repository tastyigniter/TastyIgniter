---
title: Reset Password
layout: default
permalink: /forgot-password/:code?

'[resetPassword]':
---
<div id="page-content">
    <div class="container">
        <div class="heading-section">
            <h3><?= lang('main::account.reset.text_heading'); ?></h3>
        </div>

        <div class="row">
            <div class="content-wrap col-md-6 center-block">
                <?= component('resetPassword'); ?>
            </div>
        </div>
    </div>
</div>