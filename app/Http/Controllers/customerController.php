<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Carbon\Carbon;

class customerController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Customer();
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
            'phone'=>'required|string',
            'name'=>'required|string'
        ]);
        $arrayInput = $request->all();
        $model = new Customer();
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
        $model = new Customer();

        $Customer =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Customer
        ];
        return response()->json($return);
    }

    public function delete($id)
    {
        
        $model = new Customer();

        $model->deletev2( $id);
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
            'name'=>'string',
        ]);
        
        $arrayInput = $request->all();
        $model = new Customer();

        $Customer =$model->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Customer
        ];
        
        return response()->json($return);
    }
}

