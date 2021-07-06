<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;
use App\Variable;

class medicineController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Medicine();

        $results = $model->Search($arrayInput);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];
        return response()->json($return);

    }

    public function create(Request $request)
    {
        $request->validate([
            'code'=>'required|string',
            'unit'=>'required|string',
            'cost_per_med'=>'required|integer'
        ]);

        $arrayInput = $request->all();

        $model = new medicine;

        $medicine = $model->Search([]);

        $count_medicine  = $medicine->count();

        $model = new Medicine();

        $model_variable = new Variable;

        $limit = $model_variable->where('key','Max_Medicine')->first()->value ?? 30;

        if ($count_medicine < $limit)
       { 
        $results = $model->createv2($arrayInput);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);
        }

        $return['data'] = null;

        $return['message'] = 'Vuot qua so luong thuoc!';

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        $model = new Medicine();

        $Medicine =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicine
        ];
        return response()->json($return);
    }

    public function delete( $id)
    {
        
        $model = new Medicine();

        $model->deletev2($id);

        $return = [
            'status' => '1',
            'code' => '200',
            'message' => 'deleted'
        ];

        return response()->json($return);
    }

    public function update(Request $request, $id)
    {
        $arrayInput = $request->all();

        $model = new Medicine();

        $Medicine = $model->where('id', $id)->first()->updatev2($arrayInput);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicine
        ];
        
        return response()->json($return);
    }
}
