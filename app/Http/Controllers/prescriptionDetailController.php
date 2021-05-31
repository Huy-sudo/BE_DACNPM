<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Prescriptions_detail;

class prescriptionDetailController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Prescriptions_detail;
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
            'prescription_id'=>'required|integer',
        ]);
        $arrayInput = $request->all();
        $model = new Prescriptions_detail;
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
        $model = new Prescriptions_detail;

        $Prescriptions_detail =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Prescriptions_detail
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Prescriptions_detail;

        $Prescriptions_detail =  $model->deletev2( $id);
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
            'status'=>'integer'
        ]);
        
        $arrayInput = $request->all();

        $model = new Prescriptions_detail;

        $Prescriptions_detail =$model->where('id',$id)->first()->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Prescriptions_detail
        ];
        
        return response()->json($return);
    }
}