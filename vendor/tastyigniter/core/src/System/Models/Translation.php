<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Exception;
use Igniter\Flame\Database\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $translation_id
 * @property string $locale
 * @property string $namespace
 * @property string $group
 * @property string $item
 * @property string $text
 * @property bool $unstable
 * @property bool $locked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $code
 * @method static Builder<static>|Translation applyFilters(array $options = [])
 * @method static Builder<static>|Translation applySorts(array $sorts = [])
 * @method static Builder<static>|Translation listFrontEnd(array $options = [])
 * @method static Builder<static>|Translation newModelQuery()
 * @method static Builder<static>|Translation newQuery()
 * @method static Builder<static>|Translation query()
 * @mixin Model
 */
class Translation extends \Igniter\Flame\Translation\Models\Translation
{
    /**
     * Update and lock translation.
     * When loading translations into the database, locked translations will not be overwritten .
     *
     * @return bool
     * @throws Exception
     */
    public function updateAndLock($text)
    {
        $this->text = $text;

        return $this->lockState()->save();
    }
}
