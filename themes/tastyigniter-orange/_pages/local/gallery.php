---
title: main::default.local.text_tab_gallery
layout: local
permalink: /gallery

'[localGallery]':
---
<div id="page-content">

    <?= component('local'); ?>

    <div class="container">

        <?= partial('local/tabs', ['context' => 'gallery']); ?>

        <div class="row">
            <div class="col-sm-8 col-md-9 wrap-none wrap-left">
                <div class="content wrap-all">
                    <?= component('localGallery') ?>
                </div>
            </div>

            <div class="col-sm-4 col-md-3">
                <?= component('cart'); ?>
            </div>
        </div>
    </div>
</div>
