---
title: main::default.local.text_tab_menu
layout: local
permalink: /:location?local/menus/:category?

'[categories]':

'[localMenu]':
    menusPerPage: 50
    isGrouped: false
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-8">
                <div class="row">
                    <?= component('local'); ?>

                    <?= partial('local/tabs', ['context' => 'menus']); ?>
                </div>

                <div class="row">
                    <div class="col-md-4 wrap-none hidden-xs hidden-sm">
                        <?= component('categories'); ?>
                    </div>

                    <div class="col-sm-8">
                        <?= component('localMenu') ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <?= component('cartBox'); ?>
            </div>
        </div>
    </div>
</div>