---
title: Pages
layout: default
permalink: /pages/:slug

'[sitePage]':
    slug: ':slug'
---
<div id="page-content">
    <div class="container">
        <div id="heading" class="row">
            <div class="col-md-12">
                <div class="heading-section">
                    <h2><?= $sitePage ? $sitePage->title : null; ?></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= partial('sidebar/pages'); ?>
            </div>

            <div class="col-sm-9">
                <?= component('sitePage'); ?>
            </div>
        </div>
    </div>
</div>