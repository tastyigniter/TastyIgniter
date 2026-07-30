---
title: igniter.orange::default.account_reservations_title
layout: default
permalink: /account/reservations
security: customer

'[igniter-orange::reservation-list]': []
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-2 pe-0">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <livewire:igniter-orange::reservation-list />
                </div>
            </div>
        </div>
    </div>
</div>
