<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import_medicine_detail;

class importMedicineDetailController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Import_medicine_detail();

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
            'import_id'=>'required|integer',
            'medicine_code'=>'required|integer',
            'amount'=>'required|integer',
            'cost_per_med'=>'required|integer'
        ]);

        $arrayInput = $request->all();

        $model = new Import_medicine_detail();

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
        $model = new Import_medicine_detail();

        $Import_medicine_detail =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Import_medicine_detail
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Import_medicine_detail();

        $Import_medicine_detail =  $model->deletev2( $id);

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

        $model = new Import_medicine_detail();

        $Import_medicine_detail =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Import_medicine_detail
        ];
        
        return response()->json($return);
    }
}
