<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disease_Symptom;

class diseaseSymptomController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Disease_Symptom();

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
            'symptom_name'=>'required|string',
        ]);

        $arrayInput = $request->all();

        $model = new Disease_Symptom();

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
        $model = new Disease_Symptom();

        $Disease_Symptom =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Disease_Symptom
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Disease_Symptom();

        $Disease_Symptom =  $model->deletev2($id);

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

        $model = new Disease_Symptom();

        $Disease_Symptom = $model->updatev2($arrayInput, $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Disease_Symptom
        ];
        
        return response()->json($return);
    }
}