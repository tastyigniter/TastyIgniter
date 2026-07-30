---
title: igniter.orange::default.reviews_title
permalink: '/:location?local/reviews'
description: ''
layout: default

'[igniter-orange::local-header]': []
'[igniter-orange::review-list]': []
'[igniter-orange::cart-box]': []
---
<?php
function onStart()
{
    if (request()->route()->parameter('location') !== \Igniter\Local\Facades\Location::current()->permalink_slug) {
        return redirect()->to(page_url('home'));
    }

    if (!\Igniter\Local\Models\ReviewSettings::allowReviews()) {
        flash()->error(lang('igniter.local::default.review.alert_review_disabled'));
        return redirect()->to(page_url('home'));
    }

    return null;
}
?>
---
<div class="bg-white border-bottom border-1">
    <div class="container py-4">
        <div class="mb-3" wire:ignore>
            <a
                class="text-decoration-none"
                href="{{page_url('local.menus')}}"
            >
                <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                @lang('igniter.orange::default.button_back')
            </a>
        </div>
        <div class="row align-items-end">
            <div class="col-md-8">
                <x-igniter-orange::local-header/>
            </div>
        </div>
    </div>
</div>
<div class="container pt-3 pb-5">
    <div class="row">
        <div class="col-lg-8">
            <livewire:igniter-orange::review-list/>
        </div>

        <div class="col-lg-4 d-none d-lg-inline-block">
            <livewire:igniter-orange::cart-box/>
        </div>
    </div>
</div>
