<?php

declare(strict_types=1);

namespace Igniter\User\Console\Commands;

use Igniter\User\Classes\UserState;
use Igniter\User\Models\UserPreference;
use Illuminate\Console\Command;

class ClearUserStateCommand extends Command
{
    protected $signature = 'igniter:user-state-clear';

    protected $description = 'Clear expired user custom away status';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        UserPreference::query()
            ->where('item', UserState::USER_PREFERENCE_KEY)
            ->where('value->status', UserState::CUSTOM_STATUS)
            ->where('value->clearAfterMinutes', '!=', 0)
            ->each(function(UserPreference $preference, int $int) {
                $clearAfterMinutes = $preference->value['clearAfterMinutes'] ?? 0;
                $updatedAt = $preference->value['updatedAt'] ?? null;
                if (!$clearAfterMinutes || now()->lessThan(make_carbon($updatedAt)->addMinutes($clearAfterMinutes))) {
                    return true;
                }

                UserPreference::query()
                    ->where('id', $preference->id)
                    ->update(['value' => json_encode((new UserState)->getConfig())]);
            });
    }
}
