<?php

namespace Admin\Actions;

use Admin\Widgets\Form;
use Admin\Widgets\Toolbar;
use Illuminate\Support\Facades\Event;
use System\Classes\BaseController;
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
     * @param BaseController $controller
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

        $this->controller->bindEvent('controller.afterConstructor', function ($controller) {
            if ($controller->getUser()) $this->assigneeBindEvents();
        });
    }

    public function assigned()
    {
        $this->controller->asExtension('ListController')->index();
    }

    public function assigneeApplyScope($query)
    {
        $user = $this->controller->getUser();
        $query->whereInAssignToGroup($user->staff->groups->pluck('staff_group_id')->all());

        if ($user->staff->hasRestrictedAssignableScope())
            $query->whereAssignTo($user->staff);
    }

    protected function assigneeAssignOnEdit($assignable)
    {
        if (!$assignable->assignee_group OR $assignable->assignee)
            return;

        if ($assignable->assignee_group->autoAssignEnabled())
            return;

        $assignable->updateAssignTo(null, $this->controller->getUser()->staff);
    }

    protected function assigneeBindEvents()
    {
        $action = $this->controller->getAction();

        if ($action === 'assigned' AND $this->controller->isClassExtendedWith('Admin\Actions\ListController')) {
            $listController = $this->controller->asExtension('ListController');
            $listController->listConfig['list']['showCheckboxes'] = FALSE;

            Event::listen('admin.list.extendQuery', function ($listWidget, $query) {
                if ((bool)$this->getConfig('applyScopeOnListQuery', TRUE))
                    $this->assigneeApplyScope($query);
            });
        }

        if ($this->controller->getUser()->staff->hasGlobalAssignableScope())
            return;

        if ($this->controller->isClassExtendedWith('Admin\Actions\FormController')) {
            $this->controller->bindEvent('controller.form.extendQuery', function ($query) {
                if ((bool)$this->getConfig('applyScopeOnFormQuery', TRUE))
                    $this->assigneeApplyScope($query);
            });

            Event::listen('admin.form.extendFields', function (Form $widget) {
                if (!is_a($widget->getController(), get_class($this->controller)))
                    return;

                $this->assigneeAssignOnEdit($widget->model);
            });
        }

        if (isset($this->controller->widgets['toolbar'])) {
            $toolbarWidget = $this->controller->widgets['toolbar'];
            if ($toolbarWidget instanceof Toolbar) {
                $toolbarWidget->bindEvent('toolbar.extendButtons', function () use ($toolbarWidget) {
                    $toolbarWidget->removeButton('delete');
                });
            }
        }
    }
}