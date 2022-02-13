<?php

namespace Main\Template\Extension;

use Igniter\Flame\Pagic\Extension\AbstractExtension;

class BladeExtension extends AbstractExtension
{
    public function getDirectives()
    {
        return [
            'extends' => '@extends directive is not supported. Use theme layouts instead.',
            'include' => '@include directive is not supported. Use @partial instead.',
            'includeIf' => '@includeIf directive is not supported. Use @partial instead.',
            'includeWhen' => '@includeWhen directive is not supported. Use @partial instead.',
            'includeUnless' => '@includeUnless directive is not supported. Use @partial instead.',
            'includeFirst' => '@includeFirst directive is not supported. Use @partial instead.',
            'each' => '@each directive is not supported. Use @partial instead.',
            'endcomponent' => '@endcomponent directive is not supported. Use @component instead.',
            'componentfirst' => '@componentfirst directive is not supported. Use @component instead.',
            'endcomponentfirst' => '@endcomponentfirst directive is not supported. Use @component instead.',

            'content' => [$this, 'compilesContent'],
            'component' => [$this, 'compilesComponent'],
            'hasComponent' => [$this, 'compilesHasComponent'],
            'page' => [$this, 'compilesPage'],
            'partial' => [$this, 'compilesPartial'],
            'partialIf' => [$this, 'compilesPartialIf'],

            'styles' => [$this, 'compilesStyles'],
            'scripts' => [$this, 'compilesScripts'],

            'auth' => [$this, 'compilesAuth'],
            'elseauth' => [$this, 'compileElseAuth'],
            'guest' => [$this, 'compilesGuest'],
            'elseguest' => [$this, 'compilesElseGuest'],
        ];
    }

    public function compilesContent($expression)
    {
        return "<?php echo controller()->renderContent({$expression}); ?>";
    }

    public function compilesComponent($expression)
    {
        return "<?php echo controller()->renderComponent({$expression}); ?>";
    }

    public function compilesHasComponent($expression)
    {
        return "<?php if (controller()->hasComponent({$expression})): ?>";
    }

    public function compilesPage($expression)
    {
        return '<?php echo controller()->renderPage(); ?>';
    }

    public function compilesPartial($expression)
    {
        return "<?php echo controller()->renderPartial({$expression}); ?>";
    }

    public function compilesPartialIf($expression)
    {
        return "<?php if (controller()->hasComponent({$expression})) echo controller()->renderPartial({$expression}); ?>";
    }

    public function compilesStyles($expression)
    {
        return "<?php echo Assets::getCss(); ?>\n".
            "<?php echo \$__env->yieldPushContent('styles'); ?>";
    }

    public function compilesScripts($expression)
    {
        return "<?php echo Assets::getJs(); ?>\n".
            "<?php echo \$__env->yieldPushContent('scripts'); ?>";
    }

    public function compilesAuth($guard)
    {
        $guard = $this->stripQuotes($guard);

        return $guard === 'admin'
            ? '<?php if(AdminAuth::check()): ?>'
            : '<?php if(Auth::check()): ?>';
    }

    public function compileElseAuth($guard = null)
    {
        $guard = $this->stripQuotes($guard);

        return $guard === 'admin'
            ? '<?php elseif(AdminAuth::check()): ?>'
            : '<?php elseif(Auth::check()): ?>';
    }

    public function compilesGuest($guard = null)
    {
        $guard = $this->stripQuotes($guard);

        return $guard === 'admin'
            ? '<?php if (!AdminAuth::check()): ?>'
            : '<?php if (!Auth::check()): ?>';
    }

    public function compileElseGuest($guard = null)
    {
        $guard = $this->stripQuotes($guard);

        return $guard === 'admin'
            ? '<?php elseif (!AdminAuth::check()): ?>'
            : '<?php elseif (!Auth::check()): ?>';
    }

    protected function stripQuotes($guard)
    {
        return preg_replace("/[\"\']/", '', $guard);
    }
}
