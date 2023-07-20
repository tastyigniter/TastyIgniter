<?php

namespace Admin\DashboardWidgets;

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
        $this->setProperty('cssClass', 'bg-light widget-item-onboarding');
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
