<?php

use Illuminate\Database\Seeder;
use App\Disease;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class diseasesTable extends Seeder
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
            DB::table('diseases')->insert([
                'code' => Str::random(5),
                'disease_name' => 'disease'.Str::random(1),
                'created_at'=> date("Y-m-d H:i:s"),
                'updated_at'=> date("Y-m-d H:i:s")
            ]);
            $i ++;
        }        }
}
