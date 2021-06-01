<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disease;

class diseaseController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Disease();

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
            'disease_name'=>'required|string',
        ]);

        $arrayInput = $request->all();

        $model = new Disease();

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
        $model = new Disease();

        $Disease =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Disease
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Disease();

        $Disease =  $model->deletev2( $id);

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

        $model = new Disease();

        $Disease = $model->updatev2($arrayInput, $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Disease
        ];
        
        return response()->json($return);
    }
}
