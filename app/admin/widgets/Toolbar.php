<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Html;
use Template;

class Toolbar extends BaseWidget
{
    protected $context = 'index';

    protected $defaultAlias = 'toolbar';

    protected $previewMode = FALSE;

    public $showToolbar = FALSE;

    /**
     * @var array List of CSS classes to apply to the toolbar container element
     */
    public $cssClasses = [];

    public $buttons = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'context',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('toolbar/toolbar');
    }

    public function prepareVars()
    {
        $this->prepareButtons();
        $this->vars['toolbarId'] = $this->getId();
        $this->vars['cssClasses'] = implode(' ', $this->cssClasses);
        $this->vars['buttonsHtml'] = implode(PHP_EOL, $this->getButtonList());
    }

    protected function prepareButtons()
    {
        if ($templateButtons = Template::getButtonList())
            $this->buttons['templateButtons'] = $templateButtons;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function addButtons($buttons)
    {
        foreach ($buttons as $name => $attributes) {
            $this->addButton($name, $attributes);
        }
    }

    public function addButton($name, array $attributes = [])
    {
        $this->buttons[$name] = $attributes;
    }

    public function removeButton($name)
    {
        unset($this->buttons[$name]);
    }

    public function mergeAttributes($name, array $attributes = [])
    {
        $this->buttons[$name] = array_merge($this->buttons[$name], $attributes);
    }

    public function getButtonList()
    {
        $buttons = [];
        if (!is_array($this->buttons)) {
            return $buttons;
        }

        $this->showToolbar = TRUE;

        $this->fireSystemEvent('admin.toolbar.extendButtons');

        foreach ($this->buttons as $name => $attributes) {
            if (!is_array($attributes)) {
                $buttons[$name] = $attributes;
                continue;
            }

            // Check that the toolbar button matches the active context
            if (isset($attributes['context'])) {
                $context = (array)$attributes['context'];
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            if (isset($attributes['partial'])) {
                $buttons[$name] = $this->makePartial($attributes['partial']);
            }
            else {
                foreach ($attributes as $key => $value) {
                    if ($key == 'href' AND !preg_match('#^(\w+:)?//#i', $value)) {
                        $attributes[$key] = $this->controller->pageUrl($value);
                    }
                    else if (is_string($value)) {
                        $attributes[$key] = lang($value);
                    }
                }

                $_attributes = Html::attributes(array_except($attributes, ['label', 'context', 'partial']));
                $buttons[$name] = '<a'.$_attributes.' tabindex="0">'.(isset($attributes['label']) ? $attributes['label'] : $name).'</a>';
            }
        }

        return $buttons;
    }
}
