<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $propertySeeder = new PropertySeeder();
        $analyticTypeSeeder = new AnalyticTypeSeeder();
        $propertyAnalyticSeeder = new PropertyAnalyticsSeeder();

        $propertySeeder->run();
        $analyticTypeSeeder->run();
        $propertyAnalyticSeeder->run();
    }
}
