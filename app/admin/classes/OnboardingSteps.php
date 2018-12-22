<?php namespace Admin\Classes;

use Igniter\Flame\Traits\Singleton;
use System\Classes\ExtensionManager;

/**
 * Onboarding step definition
 * This contains all the logic for creating, and accessing onboarding steps.
 *
 * @package Admin
 */
class OnboardingSteps
{
    use Singleton;

    /**
     * @var array Cache of registration callbacks.
     */
    private static $callbacks = [];

    /**
     * @var array List of registered onboarding steps.
     */
    private $steps;

    public function getStep($code)
    {
        if (!$this->steps)
            $this->loadSteps();

        return $this->steps[$code] ?? null;
    }

    public function removeStep($code)
    {
        unset($this->steps[$code]);
    }

    /**
     * Returns a list of registered onboarding steps.
     *
     * @return array Array keys are codes, values are onboarding steps meta array.
     */
    public function listSteps()
    {
        if (is_null($this->steps))
            $this->loadSteps();

        return $this->steps;
    }

    /**
     * Determine if all onboarding is complete.
     *
     * @return bool
     */
    public function completed()
    {
        return collect($this->steps)->filter(function ($step) {
            return !$this->stepIsCompleted($step);
        })->isEmpty();
    }

    /**
     * Determine if the onboarding is still in progress.
     *
     * @return bool
     */
    public function inProgress()
    {
        return !$this->completed();
    }

    /**
     * Get the next incomplete onboarding step, or null if all steps are completed.
     *
     * @return null|\stdClass
     */
    public function nextIncompleteStep()
    {
        return collect($this->steps)->first(function ($step) {
            return !$this->stepIsCompleted($step);
        });
    }

    protected function stepIsCompleted($callable)
    {
        return is_callable($callable) ? $callable() : FALSE;
    }

    //
    // Registration
    //

    protected function loadSteps()
    {
        if (!$this->steps)
            $this->steps = [];

        // Load manually registered components
        foreach (static::$callbacks as $callback) {
            $callback($this);
        }

        // Load extensions payment gateways
        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $id => $extension) {
            if (!method_exists($extension, 'registerOnboardingSteps'))
                continue;

            $onboardingSteps = $extension->registerOnboardingSteps();
            if (!is_array($onboardingSteps)) {
                continue;
            }

            $this->registerSteps($onboardingSteps);
        }

        usort($this->steps, function ($a, $b) {
            return $a->priority - $b->priority;
        });
    }

    /**
     * Registers the onboarding steps.
     * The argument is an array of the onboarding steps definition.
     *
     * @param array $definitions
     */
    public function registerSteps(array $definitions)
    {
        $defaultDefinitions = [
            'code' => null,
            'label' => null,
            'description' => null,
            'icon' => null,
            'url' => null,
            'priority' => null,
            'complete' => null,
        ];

        foreach ($definitions as $code => $definition) {
            $definition['code'] = $code;
            $item = (object)array_merge($defaultDefinitions, $definition);
            $item->completed = function () use ($item) {
                $callable = $item->complete ?? null;

                return $this->stepIsCompleted($callable);
            };

            $this->steps[$code] = $item;
        }
    }

    /**
     * Manually registers onboarding steps.
     * Usage:
     * <pre>
     *   Onboarding::registerCallback(function($manager){
     *       $manager->registerSteps([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public static function registerCallback(callable $callback)
    {
        static::$callbacks[] = $callback;
    }
}
