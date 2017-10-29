---
title: main::account.reviews.text_heading
layout: default
permalink: /account/reviews

'[account]':
    context: user

'[accountReviews]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('account::sidebar'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountReviews'); ?>
            </div>
        </div>
    </div>
</div>
