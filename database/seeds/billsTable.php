<?php

use Illuminate\Database\Seeder;
use App\Bill;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class billsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        while (true)
        {
            if ($i == 10)   break;
            DB::table('medicines')->insert([
                'code' => Str::random(5),
                'name' => 'medicine'.Str::random(5),
                'in_stock' => 0,
                'unit' => rand(1,2),
                'cost_per_med' => rand(1000,200000),
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }        }
}
