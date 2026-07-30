---
title: igniter.orange::default.cart_title
layout: default
permalink: /cart

'[igniter-orange::local-header]': []
'[igniter-orange::cart-box]': []
---
<div class="container py-5">
    <div class="row">
        <div class="col col-lg-6 m-auto">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3" wire:ignore>
                        <a
                            class="text-decoration-none"
                            href="{{page_url('local.menus')}}"
                        >
                            <i class="fa fa-arrow-left-long"></i>&nbsp;&nbsp;
                            @lang('igniter.orange::default.button_back')
                        </a>
                    </div>
                    <x-igniter-orange::local-header />
                </div>
            </div>
            <livewire:igniter-orange::cart-box />
        </div>
    </div>
</div>
