<?php

namespace System\Template\Extension;

use Igniter\Flame\Pagic\Extension\AbstractExtension;
use Illuminate\Support\Str;
use System\Classes\ExtensionManager;

class BladeExtension extends AbstractExtension
{
    /**
     * @var array Cache of registration callbacks.
     */
    protected $callbacks = [];

    /**
     * @var array Globally registered extension items
     */
    protected $items;

    /**
     * @var \System\Classes\ExtensionManager
     */
    protected $extensionManager;

    public function __construct()
    {
        $this->extensionManager = ExtensionManager::instance();
    }

    public function getDirectives()
    {
        return array_merge([
            'styles' => [$this, 'compilesStyles'],
            'scripts' => [$this, 'compilesScripts'],

            'auth' => [$this, 'compilesAuth'],
            'elseauth' => [$this, 'compileElseAuth'],
            'guest' => [$this, 'compilesGuest'],
            'elseguest' => [$this, 'compilesElseGuest'],

            'page' => [$this, 'compilesPage'],
            'partial' => [$this, 'compilesPartial'],
            'partialIf' => [$this, 'compilesPartialIf'],
            'partialWhen' => [$this, 'compilesPartialWhen'],
            'partialUnless' => [$this, 'compilesPartialUnless'],
            'partialFirst' => [$this, 'compilesPartialFirst'],
        ], $this->listDirectives());
    }

    /**
     * Registers the Blade directives items.
     * The argument is an array of the directives definitions. The array keys represent the
     * directive name, specific for the extension. Each element in the
     * array should be an associative array.
     * @param array $definitions An array of the extension definitions.
     */
    public function registerDirectives(array $definitions)
    {
        if ($this->items === null)
            $this->items = [];

        foreach ($definitions as $name => $callback) {
            $this->items[$name] = $callback;
        }
    }

    /**
     * Returns a list of the registered directives.
     * @return array
     */
    public function listDirectives()
    {
        if ($this->items === null)
            $this->loadDirectives();

        return $this->items ?? [];
    }

    protected function loadDirectives()
    {
        foreach ($this->callbacks as $callback) {
            $callback($this);
        }

        $bundles = $this->extensionManager->getRegistrationMethodValues('registerBladeDirectives');

        foreach ($bundles as $extensionCode => $definitions) {
            $this->registerDirectives($definitions);
        }
    }

    //
    //
    //

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

    public function compilesElseGuest($guard = null)
    {
        $guard = $this->stripQuotes($guard);

        return $guard === 'admin'
            ? '<?php elseif (!AdminAuth::check()): ?>'
            : '<?php elseif (!Auth::check()): ?>';
    }

    public function compilesPage($expression)
    {
        return '<?php echo Template::getBlock("body"); ?>';
    }

    public function compilesPartial($expression)
    {
        $expression = $this->stripParentheses($expression);
        [$partial, $data] = strpos($expression, ',') !== FALSE
            ? array_map('trim', explode(',', trim($expression, '()'), 2)) + ['', '[]']
            : [trim($expression, '()'), '[]'];

        $partial = $this->stripQuotes($partial);

        $expression = sprintf('%s, %s', '"_partials.'.$partial.'"', $data);

        return "<?php echo \$__env->make({$expression}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }

    public function compilesPartialIf($expression)
    {
        $expression = $this->stripParentheses($expression);
        [$partial, $data] = strpos($expression, ',') !== FALSE
            ? array_map('trim', explode(',', trim($expression, '()'), 2)) + ['', '[]']
            : [trim($expression, '()'), '[]'];

        $partial = $this->stripQuotes($partial);

        $expression = sprintf('%s, %s', '"_partials.'.$partial.'"', $data);

        return "<?php if (\$__env->exists({$expression})) echo \$__env->make({$expression}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }

    public function compilesPartialWhen($expression)
    {
        $expression = $this->stripParentheses($expression);
        $expression = $this->appendPartialPath($expression);

        return "<?php echo \$__env->renderWhen($expression, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>";
    }

    public function compilesPartialUnless($expression)
    {
        $expression = $this->stripParentheses($expression);
        $expression = $this->appendPartialPath($expression);

        return "<?php echo \$__env->renderWhen(! $expression, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>";
    }

    public function compilesPartialFirst($expression)
    {
        $expression = $this->stripParentheses($expression);
        $expression = $this->appendPartialPath($expression);

        return "<?php echo \$__env->first({$expression}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
    }

    public function stripQuotes($string)
    {
        return preg_replace("/[\"\']/", '', $string);
    }

    public function stripParentheses($expression)
    {
        if (Str::startsWith($expression, '(')) {
            $expression = substr($expression, 1, -1);
        }

        return $expression;
    }

    public function appendPartialPath($expression)
    {
        [$condition, $partial, $data] = strpos($expression, ',') !== FALSE
            ? array_map('trim', explode(',', trim($expression, '()'), 2)) + ['', '', '[]']
            : [trim($expression, '()'), '', '[]'];

        $partial = $this->stripQuotes($partial);

        return sprintf('%s, %s, %s', $condition, "'_partials.".$partial."'", $data);
    }
}
