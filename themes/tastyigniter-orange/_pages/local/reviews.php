---
title: main::default.local.text_tab_review
layout: local
permalink: /:location?local/reviews

'[localReview]':
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-8">
                <div class="row">
                    <?= component('local'); ?>

                    <?= partial('local/tabs', ['context' => 'reviews']); ?>
                </div>

                <?= component('localReview') ?>
            </div>

            <div class="col-sm-4">
                <?= component('cartBox'); ?>
            </div>
        </div>
    </div>
</div>
