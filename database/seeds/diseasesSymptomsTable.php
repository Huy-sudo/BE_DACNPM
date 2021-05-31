<?php

use Illuminate\Database\Seeder;
use App\Disease_Symptom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class diseasesSymptomsTable extends Seeder
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
            DB::table('diseases_symptoms')->insert([
                'code' => 'disease'.Str::random(1),
                'symptom_name' => 'symptom'.Str::random(1),
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }        
    }    
}
