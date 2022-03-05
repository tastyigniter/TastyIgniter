<?php

namespace Admin\Actions;

use Admin\Traits\Assignable;
use Admin\Widgets\Form;
use Admin\Widgets\Toolbar;
use Illuminate\Support\Facades\Event;
use System\Classes\ControllerAction;

class AssigneeController extends ControllerAction
{
    /**
     * Define controller assignee configuration array.
     *  $assigneeConfig = [
     *      'applyScopeOnListQuery'  => true',
     *      'applyScopeOnFormQuery'  => true',
     *  ];
     * @var array
     */
    public $assigneeConfig;

    public $requiredProperties = [];

    /**
     * @var array Required controller configuration array keys
     */
    protected $requiredConfig = [];

    /**
     * Assignee Controller constructor.
     *
     * @param \Illuminate\Routing\Controller $controller
     *
     * @throws \Exception
     */
    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->assigneeConfig = $controller->assigneeConfig;

        // Build configuration
        $this->setConfig($controller->assigneeConfig, $this->requiredConfig);

        $this->hideAction([
            'assigneeApplyScope',
        ]);

        $this->controller->bindEvent('controller.beforeRemap', function () {
            if (!$this->controller->getUser())
                return;

            $this->assigneeBindToolbarEvents();
            $this->assigneeBindListsEvents();
            $this->assigneeBindFormEvents();
        });
    }

    public function assigneeApplyScope($query)
    {
        $user = $this->controller->getUser();

        if ($user->hasGlobalAssignableScope())
            return;

        $query->whereInAssignToGroup($user->groups->pluck('user_group_id')->all());

        if ($user->hasRestrictedAssignableScope())
            $query->whereAssignTo($user->getKey());
    }

    protected function assigneeBindToolbarEvents()
    {
        if ($this->controller->getUser()->hasGlobalAssignableScope())
            return;

        if (isset($this->controller->widgets['toolbar'])) {
            $toolbarWidget = $this->controller->widgets['toolbar'];
            if ($toolbarWidget instanceof Toolbar) {
                $toolbarWidget->bindEvent('toolbar.extendButtons', function () use ($toolbarWidget) {
                    $toolbarWidget->removeButton('delete');
                });
            }
        }
    }

    protected function assigneeBindListsEvents()
    {
        if ($this->controller->isClassExtendedWith('Admin\Actions\ListController')) {
            Event::listen('admin.list.extendQuery', function ($listWidget, $query) {
                if (!(bool)$this->getConfig('applyScopeOnListQuery', TRUE))
                    return;

                $this->assigneeApplyScope($query);
            });

            Event::listen('admin.filter.extendScopesBefore', function ($widget) {
                if (!$this->controller->getUser()->hasRestrictedAssignableScope())
                    return;

                unset($widget->scopes['assignee']);
            });
        }
    }

    protected function assigneeBindFormEvents()
    {
        if ($this->controller->isClassExtendedWith('Admin\Actions\FormController')) {
            $this->controller->bindEvent('admin.controller.extendFormQuery', function ($query) {
                if (!(bool)$this->getConfig('applyScopeOnFormQuery', TRUE))
                    return;

                $this->assigneeApplyScope($query);
            });

            Event::listen('admin.form.extendFields', function (Form $widget) {
                if (!is_a($widget->getController(), get_class($this->controller)))
                    return;

                if (!in_array(Assignable::class, class_uses_recursive(get_class($widget->model))))
                    return;

                $assignable = $widget->model;
                if (!$assignable->hasAssignToGroup() || $assignable->hasAssignTo())
                    return;

                // Let the allocator handle assignment when auto assign is enabled
                if ($assignable->assignee_group->autoAssignEnabled())
                    return;

                $user = $this->controller->getUser();
                if (!$assignable->isAssignedToStaffGroup($user))
                    return;

                $assignable->assignTo($user);
            });
        }
    }
}
