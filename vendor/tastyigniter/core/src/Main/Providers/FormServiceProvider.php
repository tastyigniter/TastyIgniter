<?php

declare(strict_types=1);

namespace Igniter\Main\Providers;

use Igniter\Admin\Classes\Widgets;
use Igniter\Main\FormWidgets\Components;
use Igniter\Main\FormWidgets\MediaFinder;
use Igniter\Main\FormWidgets\TemplateEditor;
use Illuminate\Support\ServiceProvider;
use Override;

class FormServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        resolve(Widgets::class)->registerFormWidgets(function(Widgets $manager) {
            $manager->registerFormWidget(Components::class, [
                'label' => 'Components',
                'code' => 'components',
            ]);

            $manager->registerFormWidget(MediaFinder::class, [
                'label' => 'Media finder',
                'code' => 'mediafinder',
            ]);

            $manager->registerFormWidget(TemplateEditor::class, [
                'label' => 'Template editor',
                'code' => 'templateeditor',
            ]);
        });
    }
}
