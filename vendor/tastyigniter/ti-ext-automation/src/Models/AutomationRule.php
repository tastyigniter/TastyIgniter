<?php

declare(strict_types=1);

namespace Igniter\Automation\Models;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseAction;
use Igniter\Automation\Classes\BaseCondition;
use Igniter\Automation\Classes\BaseEvent;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Validation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Override;
use Throwable;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string|null $event_class
 * @property array|null $config_data
 * @property bool $is_custom
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $event_description
 * @property-read mixed $event_name
 * @method static Builder<static>|AutomationRule applyClass($class)
 * @method static Builder<static>|AutomationRule applyFilters(array $options = [])
 * @method static Builder<static>|AutomationRule applySorts(array $sorts = [])
 * @method static Builder<static>|AutomationRule applyStatus($status = true)
 * @method static Builder<static>|AutomationRule dropdown(string $column, string $key = null)
 * @method static Builder<static>|AutomationRule like(string $column, string $value, string $side = 'both', string $boolean = 'and')
 * @method static Builder<static>|AutomationRule listFrontEnd(array $options = [])
 * @method static Builder<static>|AutomationRule lists(string $column, string $key = null)
 * @method static Builder<static>|AutomationRule newModelQuery()
 * @method static Builder<static>|AutomationRule newQuery()
 * @method static Builder<static>|AutomationRule orLike(string $column, string $value, string $side = 'both')
 * @method static Builder<static>|AutomationRule orSearch(string $term, string $columns = [], string $mode = 'all')
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static Builder<static>|AutomationRule query()
 * @method static Builder<static>|AutomationRule search(string $term, string $columns = [], string $mode = 'all')
 * @method static Builder<static>|AutomationRule whereCode($value)
 * @method static Builder<static>|AutomationRule whereConfigData($value)
 * @method static Builder<static>|AutomationRule whereCreatedAt($value)
 * @method static Builder<static>|AutomationRule whereDescription($value)
 * @method static Builder<static>|AutomationRule whereEventClass($value)
 * @method static Builder<static>|AutomationRule whereId($value)
 * @method static Builder<static>|AutomationRule whereIsCustom($value)
 * @method static Builder<static>|AutomationRule whereName($value)
 * @method static Builder<static>|AutomationRule whereStatus($value)
 * @method static Builder<static>|AutomationRule whereUpdatedAt($value)
 * @mixin Model
 */
class AutomationRule extends Model
{
    use Purgeable;
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_automation_rules';

    public $timestamps = true;

    public $relation = [
        'hasMany' => [
            'conditions' => [RuleCondition::class, 'delete' => true],
            'actions' => [RuleAction::class, 'delete' => true],
            'logs' => [AutomationLog::class, 'delete' => true],
        ],
    ];

    protected $casts = [
        'config_data' => 'array',
    ];

    protected $purgeable = ['actions', 'conditions'];

    public $rules = [
        'name' => ['sometimes', 'required', 'string'],
        'code' => ['sometimes', 'required', 'alpha_dash', 'unique:igniter_automation_rules,code'],
        'event_class' => ['required'],
    ];

    /**
     * Kicks off this notification rule, fires the event to obtain its parameters,
     * checks the rule conditions evaluate as true, then spins over each action.
     */
    public function triggerRule(): ?bool
    {
        try {
            if (!$this->actions || $this->actions->isEmpty()) {
                throw new AutomationException('No actions found for this rule');
            }

            $params = $this->getEventObject()->getEventParams();

            if ($this->conditions && !$this->checkConditions($params)) {
                return false;
            }

            $this->actions->each(function(RuleAction $action) use ($params): void {
                $action->triggerAction($params);
            });
        } catch (Throwable $ex) {
            AutomationLog::createLog($this, $ex->getMessage(), false, $params ?? [], $ex);
        }

        return null;
    }

    public function getEventClassOptions(): array
    {
        return array_map(fn(BaseEvent $eventObj): string => $eventObj->getEventName().' - '.$eventObj->getEventDescription(), BaseEvent::findEventObjects());
    }

    public function getActionOptions(): array
    {
        return array_map(fn(BaseAction $actionObj) => $actionObj->getActionName(), BaseAction::findActions());
    }

    public function getConditionOptions(): array
    {
        return array_map(fn(BaseCondition $conditionObj) => $conditionObj->getConditionName(), BaseCondition::findConditions());
    }

    //
    // Attributes
    //

    public function getEventNameAttribute()
    {
        return $this->getEventObject()?->getEventName() ?? 'Unknown';
    }

    public function getEventDescriptionAttribute()
    {
        return $this->getEventObject()?->getEventDescription() ?? 'Unknown';
    }

    //
    // Events
    //

    #[Override]
    protected function afterFetch()
    {
        $this->applyEventClass();
    }

    //
    // Scope
    //

    public function scopeApplyStatus($query, $status = true)
    {
        return $query->where('status', $status);
    }

    public function scopeApplyClass($query, $class)
    {
        if (!is_string($class)) {
            $class = $class::class;
        }

        return $query->where('event_class', $class);
    }

    //
    // Manager
    //
    /**
     * Extends this class with the event class
     * @param string $class Class name
     */
    public function applyEventClass($class = null): bool
    {
        $class ??= $this->event_class;

        rescue(function() use ($class): void {
            if ($class && !$this->isClassExtendedWith($class)) {
                $this->extendClassWith($class);
            }

            $this->event_class = $class;
        });

        return (bool) $this->event_class;
    }

    /**
     * Returns the event class extension object.
     * @return BaseEvent|null
     */
    public function getEventObject(): mixed
    {
        return $this->applyEventClass()
            ? $this->asExtension($this->getEventClass())
            : null;
    }

    public function getEventClass()
    {
        return $this->event_class;
    }

    /**
     * Returns an array of rule codes and descriptions.
     * @return Collection
     */
    public static function listRulesForEvent($eventClass)
    {
        return self::applyStatus()->applyClass($eventClass)->get();
    }

    /**
     * Synchronise all file-based rules to the database.
     */
    public static function syncAll(): void
    {
        $presets = BaseEvent::findEventPresets();
        $dbRules = self::pluck('is_custom', 'code')->toArray();
        $newRules = array_diff_key($presets, $dbRules);

        // Clean up non-customized rules
        foreach ($dbRules as $code => $isCustom) {
            if ($isCustom || !$code) {
                continue;
            }

            if (!array_key_exists($code, $presets)) {
                self::whereCode($code)->delete();
            }
        }

        // Create new rules
        foreach ($newRules as $code => $preset) {
            self::createFromPreset($code, $preset);
        }
    }

    public static function createFromPreset($code, $preset): ?AutomationRule
    {
        $actions = array_get($preset, 'actions');
        if (!$actions || !is_array($actions)) {
            return null;
        }

        $automation = new self;
        $automation->status = false;
        $automation->is_custom = false;
        $automation->code = $code;
        $automation->name = array_get($preset, 'name');
        $automation->event_class = array_get($preset, 'event');
        $automation->save();

        foreach ($actions as $actionClass => $config) {
            $ruleAction = new RuleAction;
            $ruleAction->options = $config;
            $ruleAction->class_name = $actionClass;
            $ruleAction->automation_rule_id = $automation->getKey();
            $ruleAction->save();
        }

        $conditions = array_get($preset, 'conditions', []);
        foreach ($conditions as $conditionClass => $config) {
            $ruleCondition = new RuleCondition;
            $ruleCondition->options = $config;
            $ruleCondition->class_name = $conditionClass;
            $ruleCondition->automation_rule_id = $automation->getKey();
            $ruleCondition->save();
        }

        return $automation;
    }

    protected function checkConditions($params)
    {
        $conditions = $this->conditions;
        if ($conditions->isEmpty()) {
            return true;
        }

        $validConditions = $conditions->sortBy('priority')
            ->filter(fn(RuleCondition $condition) => $condition->getConditionObject()->isTrue($params))->values();

        $matchType = $this->config_data['condition_match_type'] ?? 'all';

        if ($matchType == 'all') {
            return $conditions->count() === $validConditions->count();
        }

        return $validConditions->isNotEmpty();
    }
}
