---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}">
<head>
    @themePartial('head')
</head>
<body class="bg-light d-flex flex-column h-100 {{ $this->page->bodyClass }}">
<header id="main-header" class="bg-orange">
    <div class="container">
        <div class="logo">
            <a
                class="text-white d-inline-block py-2 fs-3"
                href="{{ page_url('home') }}"
            >@lang($this->page->title)</a>
        </div>
    </div>
</header>

<div id="page-wrapper" class="pt-4">
    @themePage
</div>

<footer id="page-footer mt-auto">
    @themePartial('footer')
</footer>
@themeScripts
</body>
</html>
