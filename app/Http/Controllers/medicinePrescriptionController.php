<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicines_prescription;

class medicinePrescriptionController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Medicines_prescription;
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
            'medicine_code'=>'required|string',
            'PD_code'=>'required|string',
            'amount'=>'required|integer',
            'uses'=>'required|integer'
        ]);
        $arrayInput = $request->all();
        $model = new Medicines_prescription;
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
        $model = new Medicines_prescription;

        $Medicines_prescription =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicines_prescription
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Medicines_prescription;

        $Medicines_prescription =  $model->deletev2( $id);
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
            'amount'=>'integer',
            'uses'=>'integer',
        ]);
        
        $arrayInput = $request->all();
        $model = new Medicines_prescription;

        $Medicines_prescription =$model->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicines_prescription
        ];
        
        return response()->json($return);
    }
}
