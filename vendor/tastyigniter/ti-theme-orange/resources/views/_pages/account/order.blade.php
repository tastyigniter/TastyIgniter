---
title: igniter.orange::default.account_order_title
layout: default
permalink: /account/order/:hash
security: all

'[igniter-orange::order-preview]':
    hideReorderBtn: false
    showCancelButton: true
'[igniter-orange::leave-review]':
    type: order
---
<div class="container">
    <div class="row py-4">
        <div class="col-sm-2 pe-0">
            <x-igniter-orange::nav code="account-menu"/>
        </div>

        <div class="col-sm-10">
            <livewire:igniter-orange::order-preview/>
        </div>
    </div>
</div>
