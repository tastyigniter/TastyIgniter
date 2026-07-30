<?php

declare(strict_types=1);

namespace Igniter\User\Models\Concerns;

use Igniter\Flame\Database\Traits\Purgeable;
use LogicException;

trait SendsInvite
{
    use Purgeable;

    public static function bootSendsInvite(): void
    {
        static::extend(function(self $model): void {
            $model->addPurgeable(['send_invite']);
        });

        static::saved(function(self $model): void {
            $model->restorePurgedValues();
            if ($model->send_invite) {
                $model->sendInvite();
            }
        });
    }

    public function mailSendInvite(array $vars = [])
    {
        throw new LogicException(sprintf(
            'The model [%s] must implement a sendsInviteGetTemplateCode() method.',
            $this::class,
        ));
    }

    public function sendInvite(): void
    {
        $this->newQuery()->where($this->getKeyName(), $this->getKey())->update([
            'reset_code' => $inviteCode = $this->generateResetCode(),
            'reset_time' => now(),
            'invited_at' => now(),
        ]);

        $this->mailSendInvite(['invite_code' => $inviteCode]);
    }
}
