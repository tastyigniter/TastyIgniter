---
title: igniter.orange::default.menus_title
permalink: '/:location?local/menus/:category?'
description: ''
layout: default
hideFooter: 1

'[igniter-orange::local-header]': []
'[igniter-orange::fulfillment]': []
'[igniter-orange::category-list]': []
'[igniter-orange::menu-item-list]': []
'[igniter-orange::cart-box]': []
'[igniter-orange::fulfillment-modal]': []
---
<div class="bg-white border-bottom border-1">
    <div class="container py-4">
        <div class="mb-3" wire:ignore>
            <a
                class="text-decoration-none"
                href="{{page_url('locations')}}"
            >
                <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                @lang('igniter.orange::default.button_back')
            </a>
        </div>
        <div class="row align-items-start">
            <div class="col-lg-8">
                <x-igniter-orange::local-header/>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="d-flex justify-content-end">
                    <div class="local-control p-3 border rounded">
                        <div class="d-inline-block w-100 fw-bold text-sm-left text-md-center">
                            <x-igniter-orange::fulfillment/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sticky-top bg-white border-bottom border-1">
    <div class="container">
        <x-igniter-orange::category-list/>
    </div>
</div>
<div class="container pt-3 pb-5">
    <div class="row">
        <div class="col-lg-8">
            <livewire:igniter-orange::menu-item-list/>
        </div>

        <div class="col-lg-4 d-none d-lg-inline-block">
            <livewire:igniter-orange::cart-box/>
        </div>
    </div>
</div>
<livewire:igniter-orange::fulfillment-modal/>
