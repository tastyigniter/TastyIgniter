---
title: main::account.reservations.text_heading
layout: default
permalink: /account/reservations

'[account]':
    context: user

'[accountReservations]':
---
<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <?= partial('account::sidebar'); ?>
            </div>

            <div class="content-wrap col-sm-9 col-md-9">
                <?= component('accountReservations'); ?>
            </div>
        </div>
    </div>
</div>
