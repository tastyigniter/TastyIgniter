<?php

declare(strict_types=1);

namespace Igniter\Main\Template\Extension;

use Igniter\System\Facades\Assets;
use Illuminate\Support\Facades\Blade;

class BladeExtension
{
    public function register(): void
    {
        Blade::directive('themeStyles', $this->compilesThemeStyles(...));
        Blade::directive('themeScripts', $this->compilesThemeScripts(...));

        Blade::directive('themePage', $this->compilesThemePage(...));
        Blade::directive('themeContent', $this->compilesThemeContent(...));

        Blade::directive('themeComponent', $this->compilesThemeComponent(...));
        Blade::directive('themeComponentIf', $this->compilesThemeComponentIf(...));
        Blade::directive('themeComponentWhen', $this->compilesThemeComponentWhen(...));
        Blade::directive('themeComponentUnless', $this->compilesThemeComponentUnless(...));
        Blade::directive('themeComponentFirst', $this->compilesThemeComponentFirst(...));

        Blade::directive('themePartial', $this->compilesThemePartial(...));
        Blade::directive('themePartialIf', $this->compilesThemePartialIf(...));
        Blade::directive('themePartialWhen', $this->compilesThemePartialWhen(...));
        Blade::directive('themePartialUnless', $this->compilesThemePartialUnless(...));
        Blade::directive('themePartialFirst', $this->compilesThemePartialFirst(...));
        Blade::directive('themePartialEach', $this->compilesThemePartialEach(...));
    }

    //
    //
    //

    public function compilesThemeStyles(string $expression): string
    {
        return sprintf("<?php echo \\%s::getCss(); ?>\n<?php echo \$__env->yieldPushContent('styles'); ?>", Assets::class);
    }

    public function compilesThemeScripts(string $expression): string
    {
        return sprintf("<?php echo \\%s::getJs(); ?>\n<?php echo \$__env->yieldPushContent('scripts'); ?>", Assets::class);
    }

    //
    //
    //

    public function compilesThemePage(string $expression): string
    {
        return '<?php echo controller()->renderPage(); ?>';
    }

    public function compilesThemeContent(string $expression): string
    {
        return sprintf('<?php echo controller()->renderContent(%s); ?>', $expression);
    }

    public function compilesThemeComponent(string $expression): string
    {
        return sprintf('<?php echo controller()->renderComponent(%s); ?>', $expression);
    }

    public function compilesThemeComponentIf(string $expression): string
    {
        return sprintf('<?php if (controller()->hasComponent(%s)) echo controller()->renderComponent(%s); ?>', $expression, $expression);
    }

    public function compilesThemeComponentWhen(string $expression): string
    {
        return sprintf('<?php echo controller()->renderComponentWhen(%s); ?>', $expression);
    }

    public function compilesThemeComponentUnless(string $expression): string
    {
        return sprintf('<?php echo controller()->renderComponentUnless(%s); ?>', $expression);
    }

    public function compilesThemeComponentFirst(string $expression): string
    {
        return sprintf('<?php echo controller()->renderComponentFirst(%s); ?>', $expression);
    }

    public function compilesThemePartial(string $expression): string
    {
        return sprintf('<?php echo controller()->renderPartial(%s); ?>', $expression);
    }

    public function compilesThemePartialIf(string $expression): string
    {
        return sprintf('<?php if (controller()->hasPartial(%s)) echo controller()->renderPartial(%s); ?>', $expression, $expression);
    }

    public function compilesThemePartialWhen(string $expression): string
    {
        return sprintf('<?php echo controller()->renderPartialWhen(%s); ?>', $expression);
    }

    public function compilesThemePartialUnless(string $expression): string
    {
        return sprintf('<?php echo controller()->renderPartialUnless(%s); ?>', $expression);
    }

    public function compilesThemePartialFirst(string $expression): string
    {
        return sprintf('<?php echo controller()->renderPartialFirst(%s); ?>', $expression);
    }

    public function compilesThemePartialEach(string $expression): string
    {
        return sprintf('<?php echo controller()->renderPartialEach(%s); ?>', $expression);
    }
}
