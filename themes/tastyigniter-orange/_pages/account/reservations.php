---
title: Account Reservations
layout: default
permalink: /account/reservations

'[account]':
    security: customer

'[accountReservations]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('sidebar/account'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountReservations'); ?>
            </div>
        </div>
    </div>
</div>
