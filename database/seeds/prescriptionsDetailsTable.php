<?php

use App\Prescriptions_detail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class prescriptionsDetailsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Prescriptions_detail();
        
        $i = 0;
        while (true)
        {
            if ($i == 40)   break;
            $code = $model->generateCode() + $i;
            DB::table('prescriptions_details')->insert([
                'prescription_id' => rand(1,10),
                'price_medicines' => 0,
                'code' => $code,
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }
    }
}
