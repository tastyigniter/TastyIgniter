<?php

declare(strict_types=1);

namespace Igniter\System\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static string $siteUrl = 'http://localhost/';

    public static string $siteName = 'TastyIgniter';

    public static string $siteEmail = 'admin@domain.tld';

    public static string $staffName = 'Chef Admin';

    public static string $username = 'admin';

    public static string $password = '123456';

    public static bool $seedInitial = true;

    public static bool $seedDemo = true;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            InitialSchemaSeeder::class,
            DemoSchemaSeeder::class,
            UpdateRecordsSeeder::class,
        ]);
    }
}
