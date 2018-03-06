---
title: main::default.local.text_tab_gallery
layout: local
permalink: /:location?local/gallery

'[localGallery]':
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-8">
                <div class="row">
                    <?= component('local'); ?>

                    <?= partial('local/tabs', ['context' => 'gallery']); ?>
                </div>

                <?= component('localGallery') ?>
            </div>

            <div class="col-sm-4">
                <?= component('cartBox'); ?>
            </div>
        </div>
    </div>
</div>