<?php

declare(strict_types=1);

namespace Igniter\Automation\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Validation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Carbon;
use Throwable;

/**
 * @property int $id
 * @property int|null $automation_rule_id
 * @property int|null $rule_action_id
 * @property bool $is_success
 * @property string $message
 * @property array|null $params
 * @property array|null $exception
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $action_name
 * @property-read mixed $created_since
 * @property-read mixed $status_name
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog applyFilters(array $options = [])
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog applySorts(array $sorts = [])
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog dropdown(string $column, string $key = null)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog like(string $column, string $value, string $side = 'both', string $boolean = 'and')
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog listFrontEnd(array $options = [])
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog lists(string $column, string $key = null)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog newModelQuery()
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog newQuery()
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog orLike(string $column, string $value, string $side = 'both')
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog orSearch(string $term, string $columns = [], string $mode = 'all')
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog query()
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog search(string $term, string $columns = [], string $mode = 'all')
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereAutomationRuleId($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereCreatedAt($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereException($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereId($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereIsSuccess($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereMessage($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereParams($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereRuleActionId($value)
 * @method static \Igniter\Flame\Database\Builder<static>|AutomationLog whereUpdatedAt($value)
 * @mixin Model
 */
class AutomationLog extends Model
{
    use Prunable;
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_automation_logs';

    public $timestamps = true;

    public $relation = [
        'belongsTo' => [
            'rule' => [AutomationRule::class, 'key' => 'automation_rule_id'],
            'action' => [RuleAction::class, 'foreignKey' => 'rule_action_id'],
        ],
    ];

    public $rules = [
        'automation_rule_id' => 'integer',
        'rule_action_id' => 'nullable|integer',
        'is_success' => 'boolean',
        'message' => 'string',
        'params' => 'array',
        'exception' => ['nullable', 'array'],
    ];

    protected $casts = [
        'automation_rule_id' => 'integer',
        'rule_action_id' => 'integer',
        'is_success' => 'boolean',
        'params' => 'array',
        'exception' => 'array',
    ];

    protected $appends = ['action_name', 'status_name', 'created_since'];

    public static function createLog($rule, string $message, bool $isSuccess, array $params = [], ?Throwable $exception = null): static
    {
        $record = new static;
        if ($rule instanceof RuleAction) {
            $record->automation_rule_id = $rule->automation_rule_id;
            $record->rule_action_id = $rule->getKey();
        } else {
            $record->automation_rule_id = $rule->getKey();
            $record->rule_action_id = null;
        }

        $record->is_success = $isSuccess;
        $record->message = $message;
        $record->params = $params;
        $record->exception = $exception instanceof Throwable ? [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ] : null;

        $record->save();

        return $record;
    }

    public function getStatusNameAttribute($value): string
    {
        return lang($this->is_success
            ? 'igniter.automation::default.text_success'
            : 'igniter.automation::default.text_failed',
        );
    }

    public function getActionNameAttribute($value)
    {
        return optional($this->action)->name ?? '--';
    }

    public function getCreatedSinceAttribute($value): ?string
    {
        return $this->created_at ? time_elapsed($this->created_at) : null;
    }

    //
    // Concerns
    //

    public function prunable(): Builder
    {
        return static::query()
            ->whereNotNull('created_at')
            ->where('created_at', '<=', now()->subDays(setting('activity_log_timeout', 60)));
    }
}
