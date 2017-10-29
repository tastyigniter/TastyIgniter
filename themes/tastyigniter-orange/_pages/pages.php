---
title: main::pages.text_heading
layout: default
permalink: /pages/{slug}

'[pages]':
---
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <?= component('pages::sidebar'); ?>
            </div>

            <div class="col-sm-9">
                <?= component('pages'); ?>
            </div>
        </div>
    </div>
</div>