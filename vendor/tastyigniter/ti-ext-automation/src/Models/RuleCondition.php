<?php

declare(strict_types=1);

namespace Igniter\Automation\Models;

use Igniter\Automation\Classes\BaseCondition;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
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
 * @method static Builder<static>|RuleCondition applyFilters(array $options = [])
 * @method static Builder<static>|RuleCondition applySorts(array $sorts = [])
 * @method static Builder<static>|RuleCondition dropdown(string $column, string $key = null)
 * @method static Builder<static>|RuleCondition like(string $column, string $value, string $side = 'both', string $boolean = 'and')
 * @method static Builder<static>|RuleCondition listFrontEnd(array $options = [])
 * @method static Builder<static>|RuleCondition lists(string $column, string $key = null)
 * @method static Builder<static>|RuleCondition newModelQuery()
 * @method static Builder<static>|RuleCondition newQuery()
 * @method static Builder<static>|RuleCondition orLike(string $column, string $value, string $side = 'both')
 * @method static Builder<static>|RuleCondition orSearch(string $term, string $columns = [], string $mode = 'all')
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static Builder<static>|RuleCondition query()
 * @method static Builder<static>|RuleCondition search(string $term, string $columns = [], string $mode = 'all')
 * @method static Builder<static>|RuleCondition whereAutomationRuleId($value)
 * @method static Builder<static>|RuleCondition whereClassName($value)
 * @method static Builder<static>|RuleCondition whereCreatedAt($value)
 * @method static Builder<static>|RuleCondition whereId($value)
 * @method static Builder<static>|RuleCondition whereOptions($value)
 * @method static Builder<static>|RuleCondition whereUpdatedAt($value)
 * @mixin Model
 */
class RuleCondition extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'igniter_automation_rule_conditions';

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
        return $this->getConditionObject()?->getConditionName() ?? 'Unknown';
    }

    public function getDescriptionAttribute()
    {
        return $this->getConditionObject()?->getConditionDescription() ?? 'Unknown';
    }

    //
    // Events
    //

    #[Override]
    protected function afterFetch()
    {
        $this->applyConditionClass();
    }

    /**
     * Extends this model with the condition class
     * @param string $class Class name
     */
    public function applyConditionClass($class = null): bool
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
     * @return BaseCondition|null
     */
    public function getConditionObject(): mixed
    {
        return $this->applyConditionClass()
            ? $this->asExtension($this->getConditionClass())
            : null;
    }

    public function getConditionClass()
    {
        return $this->class_name;
    }
}
