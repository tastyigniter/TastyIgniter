<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Middleware;

use Igniter\User\Facades\Auth;
use Igniter\User\Http\Middleware\InjectImpersonateBanner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Mockery;

beforeEach(function(): void {
    $this->middleware = new InjectImpersonateBanner;
    $this->response = Mockery::mock(Response::class);
    $this->request = Mockery::mock(Request::class)->makePartial();
    app()->instance('request', $this->request);

    $this->next = fn($request) => $this->response;
});

it('injects banner into html response body when user is impersonator and route is theme', function(): void {
    $this->request->shouldReceive('path')->andReturn('/');
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturnTrue();
    Auth::shouldReceive('check')->andReturnTrue();
    Auth::shouldReceive('isImpersonator')->andReturnTrue();
    $this->response->shouldReceive('getContent')->andReturn('<html><body>Content</body></html>');
    $this->response->shouldReceive('setContent')->with('<html><body>Content<div>Impersonate Banner</div></body></html>');
    View::shouldReceive('make')->with('igniter.user::_partials.impersonate_banner')->andReturnSelf();
    View::shouldReceive('render')->andReturn('<div>Impersonate Banner</div>');

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});

it('append banner to response when user is impersonator and route is theme', function(): void {
    $this->request->shouldReceive('path')->andReturn('/');
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturnTrue();
    Auth::shouldReceive('check')->andReturnTrue();
    Auth::shouldReceive('isImpersonator')->andReturnTrue();
    $this->response->shouldReceive('getContent')->andReturn('Content');
    $this->response->shouldReceive('setContent')->with('Content<div>Impersonate Banner</div>');
    View::shouldReceive('make')->with('igniter.user::_partials.impersonate_banner')->andReturnSelf();
    View::shouldReceive('render')->andReturn('<div>Impersonate Banner</div>');

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});

it('does not inject banner when route is not theme', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturnFalse();

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});

it('does not inject banner when running in admin', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturn(true);
    $this->request->shouldReceive('path')->andReturn('admin/customers');

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});

it('does not inject banner when user is not logged in', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturn(true);
    $this->request->shouldReceive('path')->andReturn('/');
    Auth::shouldReceive('check')->andReturn(false);

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});

it('does not inject banner when user is not impersonator', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.theme.*')->andReturn(true);
    $this->request->shouldReceive('path')->andReturn('/');
    Auth::shouldReceive('check')->andReturn(true);
    Auth::shouldReceive('isImpersonator')->andReturn(false);

    $result = $this->middleware->handle($this->request, $this->next);

    expect($result)->toBe($this->response);
});
