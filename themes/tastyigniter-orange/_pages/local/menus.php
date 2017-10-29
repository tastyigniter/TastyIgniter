---
title: main::default.local.text_tab_menu
layout: local
permalink: /menus

'[categories]':

'[localMenu]':
pageLimit: 50
---
<div id="page-content">

    <?= component('local'); ?>

    <div class="container">

        <?= partial('local/tabs', ['context' => 'menus']); ?>

        <div class="row">
            <div class="col-sm-8 col-md-9 wrap-none wrap-left">
                <div class="content wrap-all">
                    <div class="row">
                        <div class="col-md-3 wrap-none hidden-xs hidden-sm">
                            <?= component('categories'); ?>
                        </div>

                        <div class="col-sm-8 col-md-9">
                            <?= component('localMenu') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-3">
                <?= component('cart'); ?>
            </div>
        </div>
    </div>
</div>
