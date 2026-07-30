<?php

declare(strict_types=1);

namespace Igniter\User\Http\Middleware;

use Closure;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class InjectImpersonateBanner
{
    public function handle($request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->routeIs('igniter.theme.*') || Igniter::runningInAdmin()) {
            return $response;
        }

        if (!Auth::check() || !Auth::isImpersonator()) {
            return $response;
        }

        $this->injectBanner($response);

        return $response;
    }

    protected function injectBanner(Response $response): void
    {
        $content = $response->getContent();
        $banner = View::make('igniter.user::_partials.impersonate_banner')->render();
        $pos = strripos($content, '</body>');
        if ($pos !== false) {
            $content = substr($content, 0, $pos).$banner.substr($content, $pos);
        } else {
            $content .= $banner;
        }

        $response->setContent($content);
    }
}
