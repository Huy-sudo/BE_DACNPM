<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report_revenue;

class reportRevenueController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();

        $model = new Report_revenue();

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
            'user_id'=>'required|integer',
        ]);

        $arrayInput = $request->all();

        $model = new Report_revenue();

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
        $model = new Report_revenue();

        $Report_revenue =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Report_revenue
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new Report_revenue();

        $Report_revenue =  $model->deletev2( $id);

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
            'user_id'=>'integer',
        ]);
        
        $arrayInput = $request->all();

        $model = new Report_revenue();

        $Report_revenue =$model->updatev2($arrayInput, $id);
        
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Report_revenue
        ];
        
        return response()->json($return);
    }
}
