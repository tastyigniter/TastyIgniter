---
title: Account Reviews
layout: default
permalink: /account/reviews/:saleType?/:saleId?

'[account]':
    security: customer

'[accountReviews]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountReviews'); ?>
            </div>
        </div>
    </div>
</div>
