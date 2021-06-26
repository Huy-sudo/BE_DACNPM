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
            customerTable::class,
            diseasesSymptomsTable::class,
            medicineTable::class,
            prescriptionTable::class,
            prescriptionsDetailsTable::class,
            billsTable::class
        ]);
    }
}
