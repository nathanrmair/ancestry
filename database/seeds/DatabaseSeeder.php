<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(VisitorsTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(AncestorsTableSeeder::class);
        $this->call(FAQsTableSeeder::class);
        $this->call(ProviderMonthlyReportSeeder::class);
    }
}
