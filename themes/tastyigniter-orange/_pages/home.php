---
title: main::default.home.text_heading
layout: default
permalink: /

'[slider]':

'[localSearch]':
---
<?
function onInit() {
}

function onStart() {
}

function onEnd() {
}
?>
---
<?= component('slider'); ?>

<?= component('localSearch'); ?>

<div id="page-content">
    <div class="container">
        <div class="content-wrap">
            <?= partial('cta/home'); ?>
        </div>
    </div>
</div>
