<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\ToolbarButton;
use Igniter\Admin\Facades\Template;
use Igniter\User\Facades\AdminAuth;
use Override;

class Toolbar extends BaseWidget
{
    protected string $context = 'index';

    protected string $defaultAlias = 'toolbar';

    protected bool $previewMode = false;

    /**
     * @var array List of CSS classes to apply to the toolbar container element
     */
    public array $cssClasses = [];

    public array $buttons = [];

    public array $allButtons = [];

    public ?string $container = null;

    protected bool $buttonsDefined = false;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'container',
            'buttons',
            'context',
            'cssClasses',
        ]);
    }

    public function reInitialize(array $config): void
    {
        $this->setConfig($config);
        $this->initialize();
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        if (!is_null($this->container)) {
            return $this->makePartial($this->container);
        }

        return $this->makePartial('toolbar/toolbar');
    }

    public function prepareVars(): void
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

        $this->fireSystemEvent('admin.toolbar.extendButtonsBefore');

        $this->addButtons($this->buttons);

        $this->prepareButtons();

        $this->fireSystemEvent('admin.toolbar.extendButtons', [$this->allButtons]);

        $this->buttonsDefined = true;
    }

    protected function prepareButtons()
    {
        if ($templateButtons = Template::getButtonList()) {
            $this->allButtons['templateButtons'] = $templateButtons;
        }
    }

    public function renderButtonMarkup(string|ToolbarButton $buttonObj): mixed
    {
        if (is_string($buttonObj)) {
            return $buttonObj;
        }

        $partialName = array_get(
            $buttonObj->config,
            'partial',
            'toolbar/button_'.$buttonObj->type,
        );

        return $this->makePartial($partialName, ['button' => $buttonObj]);
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function addButtons(array $buttons): void
    {
        $buttons = $this->makeButtons($buttons);

        foreach ($buttons as $name => $buttonObj) {
            $this->allButtons[$name] = $buttonObj;
        }
    }

    public function addButton(string $name, array $attributes = []): void
    {
        $this->allButtons[$name] = $this->makeButton($name, $attributes);
    }

    public function removeButton(string $name): void
    {
        unset($this->allButtons[$name]);
    }

    public function mergeAttributes(string $name, array $attributes = []): void
    {
        $this->buttons[$name] = array_merge($this->buttons[$name], $attributes);
    }

    public function getButtonList(): array
    {
        $buttons = [];
        foreach ($this->allButtons as $buttonObj) {
            $buttons[$buttonObj->name] = $this->renderButtonMarkup($buttonObj);
        }

        return $buttons;
    }

    public function getActiveSaveAction(): mixed
    {
        return $this->getSession('toolbar_save_action', 'continue');
    }

    public function onChooseSaveButtonAction(): void
    {
        $data = validator(post(), [
            'toolbar_save_action' => ['required', 'string'],
        ])->validate();

        $this->putSession('toolbar_save_action', $data['toolbar_save_action']);
    }

    protected function makeButtons($buttons): array
    {
        $result = [];
        foreach ($buttons as $name => $attributes) {
            $permission = array_get($attributes, 'permission');
            if ($permission && !AdminAuth::user()?->hasPermission($permission)) {
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

    protected function makeButton(string $name, array $config): ToolbarButton
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
