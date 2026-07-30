<?php

declare(strict_types=1);

namespace Igniter\Api\Console;

use Igniter\Api\Models\Token;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Console\Command;
use Override;
use Symfony\Component\Console\Input\InputOption;

class IssueApiToken extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'igniter:api-token';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Issue API Access Tokens command.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $abilities = $this->option('abilities');
        $isForAdmin = (bool)$this->option('admin');

        $query = $isForAdmin ? User::query() : Customer::query();
        $query->where('email', $email);

        /** @var null|Customer|User $user */
        $user = $query->first();
        if (!$user) {
            $this->error($isForAdmin
                ? 'Admin user does not exist! Remove --admin option to issue token for customer.'
                : 'Customer does not exist! Maybe you forgot to add the --admin option?'
            );

            return;
        }

        $accessToken = Token::createToken($user, $name, $abilities ?: ['*']);
        $this->info(sprintf('Access Token: %s', $accessToken->plainTextToken));
    }

    /**
     * Get the console command options.
     */
    #[Override]
    protected function getOptions(): array
    {
        return [
            ['name', null, InputOption::VALUE_REQUIRED, 'The name to identify the token.'],
            ['email', null, InputOption::VALUE_REQUIRED, 'The email of the user you want to issue a token.'],
            ['admin', null, InputOption::VALUE_NONE, 'Specify to issue token for admin users'],
            ['abilities', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'The abilities of the token.'],
        ];
    }
}
