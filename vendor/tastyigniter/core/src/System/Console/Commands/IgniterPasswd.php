<?php

declare(strict_types=1);

namespace Igniter\System\Console\Commands;

use Igniter\Flame\Exception\FlashException;
use Igniter\User\Models\User;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

/**
 * Console command to change the password of an Admin user via CLI.
 *
 * Adapted from october\system\console\OctoberPasswd
 */
class IgniterPasswd extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'igniter:passwd';

    /**
     * @var string The console command description.
     */
    protected $description = 'Change the password of an Admin user.';

    /**
     * @var bool Was the password automatically generated?
     */
    protected $generatedPassword = false;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email') ?? $this->ask('Admin email to reset');

        /** @var User $user */
        if (!$user = User::whereEmail($email)->first()) {
            throw new FlashException('The specified user does not exist.');
        }

        if (is_null($password = $this->argument('password'))) {
            $password = $this->optionalSecret('Enter new password (leave blank for generated password)')
                ?: $this->generatePassword();
        }

        $user->password = $password;
        $user->save();

        $this->info('Password successfully changed.');
        if ($this->generatedPassword) {
            $this->output->writeLn('Password set to <info>'.$password.'</info>.');
        }
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getArguments(): array
    {
        return [
            ['email', InputArgument::OPTIONAL, 'The email of the Admin user o reset'],
            ['password', InputArgument::OPTIONAL, 'The new password'],
        ];
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * Also allows for a default to be specified.
     */
    protected function optionalSecret(string $question): mixed
    {
        $question = new Question($question, false);

        $question->setHidden(true)->setHiddenFallback(false);

        return $this->output->askQuestion($question);
    }

    /**
     * Generate a password and flag it as an automatically-generated password.
     */
    protected function generatePassword(): string
    {
        $this->generatedPassword = true;

        return str_random(22);
    }
}
