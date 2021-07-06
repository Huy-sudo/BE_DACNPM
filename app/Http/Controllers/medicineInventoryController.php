<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicine_inventory;

class medicineInventoryController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Medicine_inventory();
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
            'amount'=>'required|integer',
            'type'=>'required|integer'
        ]);

        $arrayInput = $request->all();

        $model = new Medicine_inventory();

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
        $model = new Medicine_inventory();

        $Medicine_inventory =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicine_inventory
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Medicine_inventory();

        $Medicine_inventory =  $model->deletev2( $id);
        
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
            'user'=>'integer',
        ]);
        
        $arrayInput = $request->all();
        $model = new Medicine_inventory();

        $Medicine_inventory = $model->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicine_inventory
        ];
        
        return response()->json($return);
    }
}
