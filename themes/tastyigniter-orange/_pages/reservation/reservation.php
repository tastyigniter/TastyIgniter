---
title: Reservation
layout: default
permalink: /reservation

'[account]':

'[booking]':
---
<div id="page-content">

    <div class="container">

        <div class="row">
            <div class="content col-sm-10 center-block">
                <?= partial('account::welcome') ?>

                <?= component('booking'); ?>
            </div>
        </div>
    </div>
</div>
