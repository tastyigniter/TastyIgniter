---
title: igniter.orange::default.account_reservation_title
layout: default
permalink: /account/reservation/:hash

'[igniter-orange::reservation-preview]': []
'[igniter-orange::leave-review]':
    type: reservation
---
<div class="container">
    <div class="row py-5">
        <div class="col-sm-2 pe-0">
            <x-igniter-orange::nav code="account-menu" />
        </div>

        <div class="col-sm-10">
            <div class="card mb-1">
                <div class="card-body">
                    <x-igniter-orange::local-header/>
                </div>
            </div>

            <livewire:igniter-orange::reservation-preview />

            <livewire:igniter-orange::leave-review />
        </div>
    </div>
</div>
