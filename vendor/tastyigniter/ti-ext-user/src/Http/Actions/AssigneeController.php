<?php

declare(strict_types=1);

namespace Igniter\User\Http\Actions;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\System\Classes\ControllerAction;
use Igniter\User\Models\Concerns\Assignable;
use Illuminate\Support\Facades\Event;

class AssigneeController extends ControllerAction
{
    /**
     * Define controller assignee configuration array.
     *  $assigneeConfig = [
     *      'applyScopeOnListQuery'  => true,
     *      'applyScopeOnFormQuery'  => true,
     *  ];
     */
    public array $assigneeConfig = [];

    public array $requiredProperties = [];

    protected array $requiredConfig = [];

    /**
     * Assignee Controller constructor.
     *
     * @param AdminController $controller
     *
     * @throws Exception
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        if (property_exists($controller, 'assigneeConfig')) {
            $this->assigneeConfig = $controller->assigneeConfig ?? [];
        }

        // Build configuration
        $this->setConfig($this->assigneeConfig, $this->requiredConfig);

        $this->hideAction([
            'assigneeApplyScope',
        ]);

        $this->controller->bindEvent('controller.beforeRemap', function(): void {
            if ($this->controller->getUser()) {
                $this->assigneeBindToolbarEvents();
                $this->assigneeBindListsEvents();
                $this->assigneeBindFormEvents();
            }
        });
    }

    public function assigneeApplyScope($query): void
    {
        $user = $this->controller->getUser();

        if ($user->hasGlobalAssignableScope()) {
            return;
        }

        $query->whereInAssignToGroup($user->groups->pluck('user_group_id')->all());

        if ($user->hasRestrictedAssignableScope()) {
            $query->whereAssignTo($user->getKey());
        }
    }

    protected function assigneeBindToolbarEvents()
    {
        if ($this->controller->getUser()->hasGlobalAssignableScope()) {
            return;
        }

        if (isset($this->controller->widgets['toolbar'])) {
            $toolbarWidget = $this->controller->widgets['toolbar'];
            if ($toolbarWidget instanceof Toolbar) {
                $toolbarWidget->bindEvent('toolbar.extendButtons', function() use ($toolbarWidget): void {
                    $toolbarWidget->removeButton('delete');
                });
            }
        }
    }

    protected function assigneeBindListsEvents()
    {
        if ($this->controller->isClassExtendedWith(ListController::class)) {
            Event::listen('admin.list.extendQuery', function($listWidget, $query): void {
                if ($this->getConfig('applyScopeOnListQuery', true)) {
                    $this->assigneeApplyScope($query);
                }
            });

            Event::listen('admin.filter.extendScopesBefore', function($widget): void {
                if ($this->controller->getUser()->hasRestrictedAssignableScope()) {
                    unset($widget->scopes['assignee']);
                }
            });
        }
    }

    protected function assigneeBindFormEvents()
    {
        if ($this->controller->isClassExtendedWith(FormController::class)) {
            $this->controller->bindEvent('admin.controller.extendFormQuery', function($query): void {
                if ($this->getConfig('applyScopeOnFormQuery', true)) {
                    $this->assigneeApplyScope($query);
                }
            });

            Event::listen('admin.form.extendFields', function(Form $widget): void {
                $assignable = $widget->model;
                $user = $this->controller->getUser();

                if (
                    is_a($widget->getController(), ((object)$this->controller)::class)
                    && in_array(Assignable::class, class_uses_recursive($widget->model !== null ? $widget->model::class : self::class))
                    && $assignable->hasAssignToGroup()
                    && !$assignable->hasAssignTo()
                    && !$assignable->assignee_group->autoAssignEnabled()
                    && !$assignable->cannotAssignToStaff($user)
                ) {
                    $assignable->assignTo($user);
                }
            });
        }
    }
}
