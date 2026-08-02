<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Support\MigrationSchema;
use Throwable;

class VerifyInstallationCommand extends Command
{
    protected $signature = 'restaurant-ops:verify-installation';

    protected $description = 'Verify the complete RestaurantOps MySQL installation';

    public function handle(): int
    {
        try {
            $this->line('Connection: '.DB::connection()->getName());
            $this->line('Database: '.DB::selectOne('select database() as name')->name);
            $this->line('Prefix: '.DB::connection()->getTablePrefix());
            $errors = [...MigrationSchema::identifierAudit()['errors'], ...MigrationSchema::databaseAudit(true)];
        } catch (Throwable $exception) {
            $errors = [$exception->getMessage()];
        }

        foreach ($errors as $error) {
            $this->components->error($error);
        }

        $this->newLine();
        $this->line($errors === [] ? '<fg=green;options=bold>PASS</>' : '<fg=red;options=bold>FAIL</>');

        return $errors === [] ? self::SUCCESS : self::FAILURE;
    }
}
