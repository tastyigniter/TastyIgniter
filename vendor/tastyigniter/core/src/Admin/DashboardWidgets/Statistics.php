<?php

declare(strict_types=1);

namespace Igniter\Admin\DashboardWidgets;

use Closure;
use Igniter\Admin\Classes\BaseDashboardWidget;
use Igniter\Flame\Exception\SystemException;
use Igniter\Local\Traits\LocationAwareWidget;
use Override;

/**
 * Statistic dashboard widget.
 */
class Statistics extends BaseDashboardWidget
{
    use LocationAwareWidget;

    /** A unique alias to identify this widget. */
    protected string $defaultAlias = 'statistics';

    protected ?array $cardDefinition = null;

    protected static array $registeredCards = [];

    public static function registerCards(Closure $callback): void
    {
        static::$registeredCards[] = $callback;
    }

    public static function clearRegisteredCards(): void
    {
        static::$registeredCards = [];
    }

    /**
     * Renders the widget.
     */
    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('statistics/statistics');
    }

    #[Override]
    public function defineProperties(): array
    {
        return [
            'card' => [
                'label' => 'igniter::admin.dashboard.text_stats_card',
                'default' => 'sale',
                'type' => 'select',
                'placeholder' => 'igniter::admin.text_please_select',
                'options' => $this->getCardOptions(),
                'validationRule' => 'required|alpha_dash',
            ],
        ];
    }

    public function getActiveCard(): mixed
    {
        return $this->property('card', 'sale');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addCss('statistics.css', 'statistics-css');
    }

    protected function getCardOptions(): array
    {
        return array_map(fn($context) => array_get($context, 'label'), $this->listCards());
    }

    protected function prepareVars()
    {
        $this->vars['statsContext'] = $context = $this->getActiveCard();
        $this->vars['statsLabel'] = $this->getCardDefinition('label', '--');
        $this->vars['statsColor'] = $this->getCardDefinition('color', 'success');
        $this->vars['statsIcon'] = $this->getCardDefinition('icon', 'fa fa-bar-chart-o');
        $this->vars['statsCount'] = $this->getValue($context);
    }

    protected function listCards(): array
    {
        $result = [];

        foreach (static::$registeredCards as $callback) {
            foreach ($callback() as $code => $config) {
                $result[$code] = $config;
            }
        }

        return $result;
    }

    protected function getCardDefinition($key, $default = null)
    {
        if (is_null($this->cardDefinition)) {
            $this->cardDefinition = array_get($this->listCards(), $this->getActiveCard());
        }

        return array_get($this->cardDefinition, $key, $default);
    }

    protected function getValue(string $cardCode): string
    {
        $start = $this->property('startDate', now()->subMonth());
        $end = $this->property('endDate', now());

        throw_unless($dataFromCallable = $this->getCardDefinition('valueFrom'), new SystemException(sprintf(
            'The card [%s] does must have a defined valueFrom property', $cardCode,
        )));

        $count = $dataFromCallable($cardCode, $start, $end, function($query) use ($start, $end) {
            $this->locationApplyScope($query);
            $query->whereBetween('created_at', [$start, $end]);
        });

        return (string)(empty($count) ? 0 : $count);
    }
}
