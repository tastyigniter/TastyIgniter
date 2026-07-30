---
title: igniter.orange::default.account_title
permalink: /account
layout: default
security: customer

'[igniter-orange::account-dashboard]': []
'[igniter-orange::account-settings]': []
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-2 pe-0">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-10">
            <x-igniter-orange::account-dashboard />
            <livewire:igniter-orange::account-settings />
        </div>
    </div>
</div>
