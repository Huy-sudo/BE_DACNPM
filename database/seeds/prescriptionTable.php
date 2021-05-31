<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Prescription;
class prescriptionTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $model = new Prescription;
        $i = 0;
        while (true)
        {
            if ($i == 40)   break;
            $code = $model->generateCode() + $i;
            DB::table('prescriptions')->insert([
                'customer_id' => rand(1,10),
                'code' => $code,
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }
    }
}

