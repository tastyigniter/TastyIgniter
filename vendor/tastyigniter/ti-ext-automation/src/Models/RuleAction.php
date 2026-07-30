<?php

declare(strict_types=1);

namespace Igniter\Automation\Models;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseAction;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Validation;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property int|null $automation_rule_id
 * @property string|null $class_name
 * @property array $options
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $description
 * @property-read mixed $name
 * @property-read AutomationRule|null $automation_rule
 * @method static Builder<static>|RuleAction applyFilters(array $options = [])
 * @method static Builder<static>|RuleAction applySorts(array $sorts = [])
 * @method static Builder<static>|RuleAction dropdown(string $column, string $key = null)
 * @method static Builder<static>|RuleAction like(string $column, string $value, string $side = 'both', string $boolean = 'and')
 * @method static Builder<static>|RuleAction listFrontEnd(array $options = [])
 * @method static Builder<static>|RuleAction lists(string $column, string $key = null)
 * @method static Builder<static>|RuleAction newModelQuery()
 * @method static Builder<static>|RuleAction newQuery()
 * @method static Builder<static>|RuleAction orLike(string $column, string $value, string $side = 'both')
 * @method static Builder<static>|RuleAction orSearch(string $term, string $columns = [], string $mode = 'all')
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static Builder<static>|RuleAction query()
 * @method static Builder<static>|RuleAction search(string $term, string $columns = [], string $mode = 'all')
 * @method static Builder<static>|RuleAction whereAutomationRuleId($value)
 * @method static Builder<static>|RuleAction whereClassName($value)
 * @method static Builder<static>|RuleAction whereCreatedAt($value)
 * @method static Builder<static>|RuleAction whereId($value)
 * @method static Builder<static>|RuleAction whereOptions($value)
 * @method static Builder<static>|RuleAction whereUpdatedAt($value)
 * @mixin Model
 * @mixin BaseAction
 */
class RuleAction extends Model
{
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_automation_rule_actions';

    public $timestamps = true;

    protected $guarded = [];

    public $relation = [
        'belongsTo' => [
            'automation_rule' => [AutomationRule::class, 'key' => 'automation_rule_id'],
        ],
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public $rules = [
        'class_name' => 'required',
    ];

    //
    // Attributes
    //

    public function getNameAttribute()
    {
        return $this->getActionObject()?->getActionName() ?? 'Unknown';
    }

    public function getDescriptionAttribute()
    {
        return $this->getActionObject()?->getActionDescription() ?? 'Unknown';
    }

    //
    // Events
    //

    #[Override]
    protected function afterFetch()
    {
        $this->applyActionClass();
        $this->loadCustomData();
    }

    #[Override]
    protected function beforeSave(): void
    {
        $this->setCustomData();
    }

    public function applyCustomData(): void
    {
        $this->setCustomData();
        $this->loadCustomData();
    }

    /**
     * Extends this model with the action class
     * @param string $class Class name
     */
    public function applyActionClass($class = null): bool
    {
        if (!$class) {
            $class = $this->class_name;
        }

        rescue(function() use ($class): void {
            if ($class && !$this->isClassExtendedWith($class)) {
                $this->extendClassWith($class);
            }

            $this->class_name = $class;
        });

        return (bool) $this->class_name;
    }

    /**
     * @return null|BaseAction
     */
    public function getActionObject(): mixed
    {
        return $this->applyActionClass()
            ? $this->asExtension($this->getActionClass())
            : null;
    }

    public function getActionClass()
    {
        return $this->class_name;
    }

    protected function loadCustomData()
    {
        $this->setRawAttributes($this->getAttributes() + $this->options, true);
    }

    protected function setCustomData(): void
    {
        if (!$actionObj = $this->getActionObject()) {
            throw new AutomationException(sprintf('Unable to find action object [%s]', $this->getActionClass()));
        }

        $config = $actionObj->getFieldConfig();
        if ($fields = array_get($config, 'fields')) {
            $fieldAttributes = array_keys($fields);
            $this->options = array_merge($this->options ?? [], array_only($this->getAttributes(), $fieldAttributes));
            $this->setRawAttributes(array_except($this->getAttributes(), $fieldAttributes));
        }
    }
}
