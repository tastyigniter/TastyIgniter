---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}">
<head>
    @partial('head')
</head>
<body class="d-flex flex-column h-100 {{ $this->page->bodyClass }}">
    <header id="main-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="logo">
                        <a class="" href="{{ page_url('home') }}">@lang($this->page->title)</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="page-wrapper" class="content-area">
        @page
    </div>

    <footer id="page-footer mt-auto">
        @partial('footer')
    </footer>
    <script type="text/javascript" src="{{ asset('app/admin/assets/js/admin.js') }}" id="app-js"></script>
    {!! get_script_tags() !!}</body>
</html>