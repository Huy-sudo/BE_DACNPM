<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uses;

class useController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Uses();

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
            'value'=>'required|string',
        ]);
        
        $arrayInput = $request->all();

        $model = new Uses();

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
        $model = new Uses();

        $Uses =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Uses
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Uses();

        $Uses =  $model->deletev2( $id);

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

        $model = new Uses();

        $Uses =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Uses
        ];
        
        return response()->json($return);
    }
}
