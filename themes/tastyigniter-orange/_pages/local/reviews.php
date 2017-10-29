---
title: main::default.local.text_tab_review
layout: local
permalink: /reviews

'[localReview]':
---
<div id="page-content">

    <?= component('local'); ?>

    <div class="container">

        <?= partial('local/tabs', ['context' => 'reviews']); ?>

        <div class="row">
            <div class="col-sm-8 col-md-9 wrap-none wrap-left">
                <div class="content wrap-all">
                    <?= component('localReview') ?>
                </div>
            </div>

            <div class="col-sm-4 col-md-3">
                <?= component('cart'); ?>
            </div>
        </div>
    </div>
</div>
