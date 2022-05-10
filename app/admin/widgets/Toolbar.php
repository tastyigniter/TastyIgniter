<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\ToolbarButton;
use Admin\Facades\AdminAuth;
use Admin\Facades\Template;

class Toolbar extends BaseWidget
{
    protected $context = 'index';

    protected $defaultAlias = 'toolbar';

    protected $previewMode = false;

    /**
     * @var array List of CSS classes to apply to the toolbar container element
     */
    public $cssClasses = [];

    public $buttons = [];

    public $allButtons = [];

    /**
     * @var string
     */
    public $container;

    protected $buttonsDefined;

    public function initialize()
    {
        $this->fillFromConfig([
            'container',
            'buttons',
            'context',
            'cssClasses',
        ]);
    }

    public function reInitialize(array $config)
    {
        $this->setConfig($config);
        $this->initialize();
    }

    public function render()
    {
        $this->prepareVars();

        if (!is_null($this->container))
            return $this->makePartial($this->container);

        return $this->makePartial('toolbar/toolbar');
    }

    public function prepareVars()
    {
        $this->defineButtons();
        $this->vars['toolbarId'] = $this->getId();
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['availableButtons'] = $this->allButtons;
    }

    protected function defineButtons()
    {
        if ($this->buttonsDefined) {
            return;
        }

        if (!is_array($this->buttons)) {
            $this->buttons = [];
        }

        $this->fireSystemEvent('admin.toolbar.extendButtonsBefore');

        $this->prepareButtons();

        $this->addButtons($this->buttons);

        $this->fireSystemEvent('admin.toolbar.extendButtons', [$this->allButtons]);

        $this->buttonsDefined = true;
    }

    protected function prepareButtons()
    {
        if ($templateButtons = Template::getButtonList())
            $this->allButtons['templateButtons'] = $templateButtons;
    }

    public function renderButtonMarkup($buttonObj)
    {
        if (is_string($buttonObj))
            return $buttonObj;

        $partialName = array_get(
            $buttonObj->config,
            'partial',
            'toolbar/button_'.$buttonObj->type
        );

        return $this->makePartial($partialName, ['button' => $buttonObj]);
    }

    public function getContext()
    {
        return $this->context;
    }

    public function addButtons($buttons)
    {
        $buttons = $this->makeButtons($buttons);

        foreach ($buttons as $name => $buttonObj) {
            $this->allButtons[$name] = $buttonObj;
        }
    }

    public function addButton($name, array $attributes = [])
    {
        $this->allButtons[$name] = $this->makeButton($name, $attributes);
    }

    public function removeButton($name)
    {
        unset($this->allButtons[$name]);
    }

    public function mergeAttributes($name, array $attributes = [])
    {
        $this->buttons[$name] = array_merge($this->buttons[$name], $attributes);
    }

    public function getButtonList()
    {
        $buttons = [];
        foreach ($this->allButtons as $buttonObj) {
            $buttons[$buttonObj->name] = $this->renderButtonMarkup($buttonObj);
        }

        return $buttons;
    }

    protected function makeButtons($buttons)
    {
        $result = [];
        foreach ($buttons as $name => $attributes) {
            $permission = array_get($attributes, 'permission');
            if ($permission && !AdminAuth::user()->hasPermission($permission)) {
                continue;
            }

            // Check that the toolbar button matches the active context
            if (isset($attributes['context'])) {
                $context = (array)$attributes['context'];
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            $buttonObj = $this->makeButton($name, $attributes);

            $result[$name] = $buttonObj;
        }

        return $result;
    }

    /**
     * @param string $name
     * @param array $config
     * @return mixed
     */
    protected function makeButton(string $name, array $config)
    {
        $buttonType = array_get($config, 'type', 'link');

        $buttonObj = new ToolbarButton($name);
        $buttonObj->displayAs($buttonType, $config);

        if ($buttonType === 'dropdown' && array_key_exists('menuItems', $config)) {
            $buttonObj->menuItems($this->makeButtons($config['menuItems']));
        }

        return $buttonObj;
    }
}
