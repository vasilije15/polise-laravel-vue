<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            InsuranceCardSeeder::class,
        ]);
        $this->call(Januar2020InsuranceCardsTableSeeder::class);
        $this->call(InsuranceCardsTableSeeder::class);
    }
}
