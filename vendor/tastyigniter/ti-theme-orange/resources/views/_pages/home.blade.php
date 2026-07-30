---
title: igniter.orange::default.home_title
description: ''
permalink: /
layout: default

'[igniter-orange::slider]':
    code: home-slider
'[igniter-orange::local-search]': []
'[igniter-orange::featured-items]': []
---
<x-igniter-orange::slider />

<div class="border-bottom">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5">
                <livewire:igniter-orange::local-search/>
            </div>
        </div>
    </div>
</div>

<x-igniter-orange::featured-items/>
