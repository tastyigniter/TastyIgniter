<?php

declare(strict_types=1);

namespace Igniter\Orange\Actions;

use Closure;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnsureUniqueProcess
{
    protected int $timeoutSeconds = 5;

    protected int $maxRetries = 5;

    protected int $retryDelay = 1;

    public function timeout(int $timeoutSeconds): static
    {
        $this->timeoutSeconds = $timeoutSeconds;

        return $this;
    }

    public function maxRetries(int $maxRetries): static
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    public function retryDelay(int $retryDelay): static
    {
        $this->retryDelay = $retryDelay;

        return $this;
    }

    public function attemptWithLock(string $lockKey, Closure $callback): mixed
    {
        $attempt = 0;
        while ($attempt < $this->maxRetries) {
            $attempt++;

            try {
                DB::beginTransaction();

                $lockResult = DB::select('SELECT GET_LOCK(?, ?) as acquired', [$lockKey, $this->timeoutSeconds]);
                $acquired = $lockResult[0]->acquired ?? 0;
                if ($acquired) {
                    $result = $callback();

                    DB::select('SELECT RELEASE_LOCK(?)', [$lockKey]);
                    DB::commit();

                    return $result;
                } else {
                    DB::rollBack();
                    Log::warning(sprintf('Lock [%s] NOT acquired on attempt #%s', $lockKey, $attempt));

                    sleep($this->retryDelay);
                }
            } catch (QueryException $ex) {
                DB::rollBack();

                if ($attempt >= $this->maxRetries) {
                    Log::error(sprintf('Failed to acquire lock [%s] on attempt #%s', $lockKey, $this->maxRetries));

                    throw $ex;
                }

                if ($ex->getCode() == 1213) {
                    Log::warning(sprintf('Deadlock detected during attempt #%s for [%s]: %s', $attempt, $lockKey, $ex->getMessage()));
                    sleep($this->retryDelay);
                    continue;
                }

                Log::error(sprintf('QueryException during attempt #%s for [%s]: %s', $attempt, $lockKey, $ex->getMessage()));
                DB::select('SELECT RELEASE_LOCK(?)', [$lockKey]);
                sleep($this->retryDelay);
            } catch (Throwable $ex) {
                DB::rollBack();
                Log::error(sprintf('Exception during attempt #%s for [%s]: %s', $attempt, $lockKey, $ex->getMessage()));
                DB::select('SELECT RELEASE_LOCK(?)', [$lockKey]);

                throw $ex;
            }
        }

        Log::error(sprintf('Failed to acquire lock [%s] after %s attempts', $lockKey, $this->maxRetries));

        throw new ApplicationException(sprintf('Failed to acquire lock [%s] after %s attempts', $lockKey, $this->maxRetries));
    }
}
