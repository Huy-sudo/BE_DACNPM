<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Variable;

class billController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Bill();
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
            'PD_code'=>'required|integer',
        ]);
        $model_variable = new Variable;
        $analysis_price = $model_variable->where('key','analysis_price')->first()->value ?? 35000;
        $arrayInput = $request->all();
        $arrayInput['analysis_price']=$analysis_price;
        $arrayInput['total_price']=$analysis_price;
        $model = new Bill();
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
        $model = new Bill();

        $Bill =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Bill
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Bill();

        $Bill =  $model->deletev2( $id);
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
            'PD_code'=>'varchar',
            'analysis_price'=>'bigint(20)',
        ]);
        
        $arrayInput = $request->all();

        $model = new Bill();

        $Bill =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Bill
        ];
        
        return response()->json($return);
    }}
