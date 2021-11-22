<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    {!! get_metas() !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! get_favicon() !!}
    <title>{{ sprintf(lang('admin::lang.site_title'), Template::getTitle(), setting('site_name')) }}</title>
    @styles
</head>
<body class="page {{ $this->bodyClass }}">
<x-header>
    {!! $this->widgets['mainmenu']->render() !!}
</x-header>
<div class="sidebar">
    <x-aside :navItems="AdminMenu::getVisibleNavItems()"/>
</div>
<div class="page-wrapper flex-grow-1 overflow-hidden">
    <div class="page-content overflow-y-scroll overflow-y-lg-auto px-3 py-4 h-100">
        {!! Template::getBlock('body') !!}
    </div>
</div>
<div id="notification">
    <x-alert/>
</div>
@partial('set_status_form')
@scripts
</body>
</html>
