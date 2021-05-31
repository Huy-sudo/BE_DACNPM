<?php

use Illuminate\Database\Seeder;
use App\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class customerTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Customer;
        
        $i = 0;
        while (true)
        {
            if ($i == 10)   break;
            $code = $model->generateCode();
            DB::table('customers')->insert([
                'phone' => rand(1000000000,9999999999),
                'name' => Str::random(10),
                'code' => $code,
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }    
    }
}
