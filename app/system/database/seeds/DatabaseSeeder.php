<?php

namespace System\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static $siteUrl = 'http://localhost/';

    public static $siteName = 'TastyIgniter';

    public static $siteEmail = 'admin@domain.tld';

    public static $staffName = 'Chef Admin';

    public static $seedDemo = TRUE;

    public static int $locationId;

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->call([
            InitialSchemaSeeder::class,
            DemoSchemaSeeder::class,
            UpdateRecordsSeeder::class,
        ]);
    }
}
