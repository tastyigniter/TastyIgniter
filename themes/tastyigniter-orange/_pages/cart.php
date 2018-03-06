---
title: main::default.cart.text_heading
layout: default
permalink: /cart

'[local]':

'[cartBox]':
---
<div id="page-content">
    <div class="container">
        <div class="content-wrap">
            <div class="cart-buttons wrap-bottom">
                <div class="center-block">
                    <a 
                        class="btn btn-default btn-block btn-md"
                       href="<?= restaurant_url('menus'); ?>"
                    ><?= lang('main::default.cart.button_go_back') ?></a>
                </div>
            </div>
            
            <?= component('cartBox'); ?>
        </div>
    </div>
</div>
