<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import_medicine;

class importMedicineController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Import_medicine();

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
            'user_id'=>'required|integer',
        ]);

        $arrayInput = $request->all();

        $model = new Import_medicine();

        $results = $model->createv2($arrayInput);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $results
        ];

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        $model = new Import_medicine();

        $Import_medicine =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Import_medicine
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Import_medicine();

        $Import_medicine =  $model->deletev2( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'message' => 'deleted'
        ];
        return response()->json($return);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'=>'integer',
        ]);
        
        $arrayInput = $request->all();

        $model = new Import_medicine();

        $Import_medicine =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Import_medicine
        ];
        
        return response()->json($return);
    }
}
