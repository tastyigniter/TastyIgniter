<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\System\Classes\ExtensionManager;

/**
 * Onboarding step definition
 * This contains all the logic for creating, and accessing onboarding steps.
 */
class OnboardingSteps
{
    /** Cache of registration callbacks. */
    private static array $callbacks = [];

    /**
     * List of registered onboarding steps.
     * @var null|array<string, OnboardingStep>
     */
    private ?array $steps = null;

    public function getStep(string $code): ?OnboardingStep
    {
        if (!$this->steps) {
            $this->loadSteps();
        }

        return $this->steps[$code] ?? null;
    }

    public function removeStep(string $code): void
    {
        unset($this->steps[$code]);
    }

    /**
     * Returns a list of registered onboarding steps.
     *
     * @return array Array keys are codes, values are onboarding steps meta array.
     */
    public function listSteps(): array
    {
        if (is_null($this->steps)) {
            $this->loadSteps();
        }

        return $this->steps;
    }

    /**
     * Determine if all onboarding is complete.
     */
    public function completed(): bool
    {
        return collect($this->steps)->filter(fn(OnboardingStep $step): bool => !$step->isCompleted())->isEmpty();
    }

    /**
     * Determine if the onboarding is still in progress.
     */
    public function inProgress(): bool
    {
        return !$this->completed();
    }

    /**
     * Get the next incomplete onboarding step, or null if all steps are completed.
     */
    public function nextIncompleteStep(): ?OnboardingStep
    {
        return collect($this->steps)->first(fn(OnboardingStep $step): bool => !$step->isCompleted());
    }

    //
    // Registration
    //

    protected function loadSteps()
    {
        if (!$this->steps) {
            $this->steps = [];
        }

        // Load manually registered components
        foreach (self::$callbacks as $callback) {
            $callback($this);
        }

        // Load extensions payment gateways
        $extensions = resolve(ExtensionManager::class)->getExtensions();
        foreach ($extensions as $extension) {
            if (!method_exists($extension, 'registerOnboardingSteps')) {
                continue;
            }

            $onboardingSteps = $extension->registerOnboardingSteps();
            if (!is_array($onboardingSteps)) {
                continue;
            }

            $this->registerSteps($onboardingSteps);
        }

        $this->steps = collect($this->steps)->sortBy('priority')->all();
    }

    /**
     * Registers the onboarding steps.
     * The argument is an array of the onboarding steps definition.
     */
    public function registerSteps(array $definitions): void
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
            $definition = array_merge($defaultDefinitions, $definition);

            $this->steps[$code] = OnboardingStep::fromArray($definition);
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
    public static function registerCallback(callable $callback): void
    {
        self::$callbacks[] = $callback;
    }

    public static function clearCallbacks(): void
    {
        self::$callbacks = [];
    }
}
