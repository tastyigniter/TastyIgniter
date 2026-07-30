<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Middleware;

use Closure;
use Igniter\Admin\Classes\AdminController;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\User\Facades\AdminAuth;
use Illuminate\Http\Request;

class InjectStatusWorkflow
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!$this->shouldInjectOrderWorkflow($request)) {
            return $response;
        }

        if ($response->isSuccessful()) {
            $content = $response->getContent();
            $insertPos = strripos((string)$content, '</body>');
            if ($insertPos !== false) {
                $content = substr((string)$content, 0, $insertPos);
                $content .= $this->renderOrderWorkflowView();
                $content .= substr($content, $insertPos);
                $response->setContent($content);
            }
        }

        return $response;
    }

    protected function shouldInjectOrderWorkflow(Request $request): bool
    {
        $enableWorkflow = setting('enable_status_workflow', true);
        $limitUsers = setting('limit_users', []);

        return $enableWorkflow
            && $request->isMethod('GET')
            && $request->route()?->getController() instanceof AdminController
            && (!$limitUsers || in_array(AdminAuth::getUser()->getKey(), $limitUsers));
    }

    protected function renderOrderWorkflowView(): string
    {
        return view('igniter.cart::_partials.orders.status_workflow_modal', [
            'locations' => Location::currentOrAssigned() ?: LocationModel::query()->whereIsEnabled()->pluck('location_id')->all(),
            'delayTimes' => collect(setting('delay_times', []))->pluck('time')->all(),
            'rejectCodes' => collect(setting('rejected_reasons', []))->pluck('code')->all(),
        ])->render();
    }
}
