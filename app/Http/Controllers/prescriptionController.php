<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\prescription;
use App\Prescriptions_detail;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use App\Variable;

class prescriptionController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new prescription;
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
            'customer_id'=>'required|integer',
        ]);

        $arrayInput = $request->all();

        $model = new prescription;

        $prescription = $model->Search(['today'=>1]);

        $count_prescription = $prescription->count();

        $model_variable = new Variable;

        $variable =  $model_variable->where('key','Analysis_Price')->first()->value ?? 30000;

        $arrayInput['analysis_price'] = $variable;

        $limit = $model_variable->where('key','Max_Prescription')->first()->value ?? 45;

        if ($count_prescription < $limit) {
            $results = $model->createv2($arrayInput);

            $model2 = new Prescriptions_detail;

            $results['PD'] = $model2->createv2(['prescription_id'=>$results->id]);

            $return = [
                'status' => '1',
                'code' => '200',
            ];

            $return['data'] = $results;

            return response()->json($return);
        }
        $return['data'] = null;

        $return['message'] = 'Vuot qua gioi han benh nhan ngay hom nay';

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        $model = new prescription;

        $prescription =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        return response()->json($return);
    }

    public function delete(Request $request, $id)
    {
        
        $model = new prescription;

        $prescription =  $model->deletev2( $id);
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

        $model = prescription::where('id',$id)->first();

        $prescription = $model->updatev2($arrayInput, $id);
       
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $prescription
        ];
        
        return response()->json($return);
    }

}
