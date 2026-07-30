<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;

/**
 * Notification Model
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array $data
 * @property Carbon|null $read_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $icon
 * @property-read mixed $icon_color
 * @property-read mixed $message
 * @property-read mixed $title
 * @property-read mixed $url
 * @property-read null|Model $notifiable
 * @method static Builder<static>|Notification query()
 * @mixin Model
 */
class Notification extends DatabaseNotification
{
    use Prunable;

    public function getTitleAttribute()
    {
        return array_get($this->data ?? [], 'title');
    }

    public function getMessageAttribute()
    {
        return array_get($this->data ?? [], 'message');
    }

    public function getUrlAttribute()
    {
        return array_get($this->data ?? [], 'url');
    }

    public function getIconAttribute()
    {
        return array_get($this->data ?? [], 'icon');
    }

    public function getIconColorAttribute()
    {
        return array_get($this->data ?? [], 'iconColor');
    }

    public function scopeWhereNotifiable(Builder $query, Model $notifiable)
    {
        return $query->whereMorphedTo('notifiable', $notifiable);
    }

    //
    // Concerns
    //

    public function prunable(): Builder
    {
        return static::query()
            ->whereNotNull('read_at')
            ->where('read_at', '<=', now()->subDays(setting('activity_log_timeout', 60)));
    }
}
