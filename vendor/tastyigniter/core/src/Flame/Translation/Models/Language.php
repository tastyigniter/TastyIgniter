<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;

/**
 * @property int $language_id
 * @property string $code
 * @property string $name
 * @property string|null $image
 * @property string $idiom
 * @property bool $status
 * @property int $can_delete
 * @property int|null $original_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $version
 * @property int $is_default
 * @method static Builder<static>|Language applyFilters(array $options = [])
 * @method static Builder<static>|Language applySorts(array $sorts = [])
 * @method static Builder<static>|Language listFrontEnd(array $options = [])
 * @method static Builder<static>|Language newModelQuery()
 * @method static Builder<static>|Language newQuery()
 * @method static Builder<static>|Language query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Language extends Model
{
    /**
     *  Table name in the database.
     * @var string
     */
    protected $table = 'languages';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'language_id';
}
