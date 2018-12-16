<?php namespace Admin\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Admin\Classes\OnboardingSteps;

/**
 * Onboard dashboard widget.
 */
class Onboarding extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'onboarding';

    public function initialize()
    {
        $this->setProperty('cssClass', 'widget-item-onboarding');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'label' => 'admin::lang.dashboard.label_widget_title',
                'default' => 'admin::lang.dashboard.onboarding.title',
            ],
        ];
    }

    /**
     * Renders the widget.
     */
    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('onboarding/onboarding');
    }

    public function loadAssets()
    {
        $this->addCss('css/onboarding.css', 'onboarding-css');
    }

    protected function prepareVars()
    {
        $this->vars['onboarding'] = $this->getOnboarding();
    }

    protected function getOnboarding()
    {
        return OnboardingSteps::instance();
    }
}
