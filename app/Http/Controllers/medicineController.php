<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine;

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

        $model = new Medicine();

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
        $model = new Medicine();

        $Medicine =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicine
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Medicine();

        $Medicine =  $model->deletev2( $id);

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
