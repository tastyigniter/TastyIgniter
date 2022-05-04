<?php

namespace System\Console\Commands;

use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Console\Command;
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
    public function handle()
    {
        $username = $this->argument('username')
            ?? $this->ask('Username to reset');

        $user = Users_model::whereUsername($username)->first()
            ?? Staffs_model::whereStaffEmail($username)->first();
        if (!$user)
            throw new ApplicationException('The specified user does not exist.');

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
    protected function getArguments()
    {
        return [
            ['username', InputArgument::OPTIONAL, 'The username of the Backend user'],
            ['password', InputArgument::OPTIONAL, 'The new password'],
        ];
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * Also allows for a default to be specified.
     *
     * @param string $question
     * @param bool $fallback
     * @return string
     */
    protected function optionalSecret($question)
    {
        $question = new Question($question, false);

        $question->setHidden(true)->setHiddenFallback(false);

        return $this->output->askQuestion($question);
    }

    /**
     * Generate a password and flag it as an automatically-generated password.
     *
     * @return string
     */
    protected function generatePassword()
    {
        $this->generatedPassword = true;

        return str_random(22);
    }
}
