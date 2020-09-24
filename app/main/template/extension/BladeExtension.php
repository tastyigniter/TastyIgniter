<?php

namespace Main\Template\Extension;

use Igniter\Flame\Pagic\Extension\AbstractExtension;

class BladeExtension extends AbstractExtension
{
    public function getDirectives()
    {
        return [
            'extends' => '@extends directive is not supported. Use theme layouts instead.',
            'content' => [$this, 'contentDirective'],
            'componentPartial' => [$this, 'componentDirective'],
            'hasComponentPartial' => [$this, 'hasComponentDirective'],
            'page' => [$this, 'pageDirective'],
            'partial' => [$this, 'partialDirective'],
            'placeholder' => [$this, 'placeholderDirective'],
            'styles' => [$this, 'stylesDirective'],
            'scripts' => [$this, 'scriptsDirective'],
            'auth' => [$this, 'authDirective'],
            'guest' => [$this, 'guestDirective'],
        ];
    }

    public function contentDirective($expression)
    {
        return "<?php echo controller()->renderContent({$expression}); ?>";
    }

    public function componentDirective($expression)
    {
        return "<?php echo controller()->renderComponent({$expression}); ?>";
    }

    public function hasComponentDirective($expression)
    {
        return "<?php if (controller()->hasComponent({$expression})): ?>";
    }

    public function pageDirective($expression)
    {
        return '<?php echo controller()->renderPage(); ?>';
    }

    public function partialDirective($expression)
    {
        return "<?php echo controller()->renderPartial({$expression}); ?>";
    }

    public function placeholderDirective($expression)
    {
        return "<?php echo \$__env->yieldPushContent({$expression}); ?>";
    }

    public function stylesDirective($expression)
    {
        return "<?php echo Assets::getCss(); ?>\n".
            "<?php echo \$__env->yieldPushContent('styles'); ?>";
    }

    public function scriptsDirective($expression)
    {
        return "<?php echo Assets::getJs(); ?>\n".
            "<?php echo \$__env->yieldPushContent('scripts'); ?>";
    }

    public function authDirective($expression)
    {
        return "<?php if (Auth::check()): ?>\n";
    }

    public function guestDirective($expression)
    {
        return "<?php if (Auth::guest()): ?>\n";
    }
}
