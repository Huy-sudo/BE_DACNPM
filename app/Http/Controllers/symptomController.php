<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Symptom;

class symptomController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Symptom();

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
            'symptom_code'=>'required|varchar',
            'disease_code'=>'required|varchar'
        ]);

        $arrayInput = $request->all();

        $model = new Symptom();

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
        $model = new Symptom();

        $Symptom =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Symptom
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Symptom();

        $Symptom =  $model->deletev2($id);

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
            'disease_code'=>'required|varchar',
            'symptom_code'=>'required|varchar'
        ]);
        
        $arrayInput = $request->all();

        $model = new Symptom();

        $Symptom = $model->updatev2($arrayInput, $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Symptom
        ];
        
        return response()->json($return);
    }
}