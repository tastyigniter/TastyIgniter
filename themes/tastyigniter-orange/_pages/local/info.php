---
title: main::default.local.text_tab_info
layout: local
permalink: /:location?local/info

'[localInfo]':
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-8">
                <div class="row">
                    <?= component('local'); ?>

                    <?= partial('local/tabs', ['context' => 'info']); ?>
                </div>

                <?= component('localInfo') ?>
            </div>

            <div class="col-sm-4">
                <?= component('cartBox'); ?>
            </div>
        </div>
    </div>
</div>
