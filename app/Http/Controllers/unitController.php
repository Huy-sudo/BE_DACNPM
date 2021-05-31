<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;

class unitController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Unit();

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

        $arrayInput = $request->all();

        $model = new Unit();

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
        $model = new Unit();

        $Unit =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Unit
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Unit();

        $Unit =  $model->deletev2( $id);

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

        $model = new Unit();

        $Unit =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Unit
        ];
        
        return response()->json($return);
    }
}
