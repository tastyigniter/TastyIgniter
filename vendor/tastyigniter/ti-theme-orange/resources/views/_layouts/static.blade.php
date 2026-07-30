---
description: Static layout for static pages
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}" class="h-100">
<head>
    @include('igniter-orange::includes.head')
    @livewireStyles
</head>
<body class="d-flex flex-column h-100 {{ $this->page->bodyClass }}">

<header class="header">
    @include('igniter-orange::includes.header')
</header>

<main role="main">
    <div id="page-wrapper">
        <div class="container pb-5">
            <div id="heading" class="heading-section py-5">
                <h2>{{ $this->page->title }}</h2>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <x-igniter-orange::nav code="pages-menu" />
                </div>

                <div class="col-sm-9">
                    <div class="card">
                        <div class="card-body">
                            @themePage
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="footer mt-auto">
    @include('igniter-orange::includes.footer')
</footer>
<div id="notification">
    <livewire:igniter-orange::utils.flash-message />
</div>
@include('igniter-orange::includes.eucookiebanner')
@livewireScripts
@include('igniter-orange::includes.scripts')
</body>
</html>
