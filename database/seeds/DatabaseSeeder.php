<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();

        // $this->call(UserSeeder::class);
        $this->call(PaymentPlatformsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
    }

    private function truncateTables()
    {
        /**
         * IMPORTANT!
         * The database seed is written to handle the task centralized
         * It should use:
         * php artisan db:seed
         * -> You can not run the seeds separately, it could cause errors!
         */
        if (App::environment() === 'production') exit();

        Eloquent::unguard();

        // Truncate all tables, except migrations
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            if ($table->{'Tables_in_' . env('DB_DATABASE')} !=='migrations')
                DB::table($table->{'Tables_in_' . env('DB_DATABASE')})->truncate();
        }
    }
}
