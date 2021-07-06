<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medicines_prescription;
use App\Medicine_inventory;
use App\Medicine;

class medicinePrescriptionController extends Controller
{
    public function index(Request $request){
        $arrayInput = $request->all();
        $model = new Medicines_prescription;
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
        $model = new Medicines_prescription;
        $model2 = new Medicine_inventory;
        $model3 = new Medicine;
        $model3 = $model3->where('code',$arrayInput['medicine_code'])->first();
        if ($arrayInput['amount'] <= $model3->in_stock)
        {
            $arrInput = [
                'type'=>'2',
                'medicine_code'=>$arrayInput['medicine_code'],
                'amount'=>$arrayInput['amount'],
            ];
            $model2 = $model2->createv2($arrInput);
            $results = $model->createv2($arrayInput);
            $return = [
                'status' => '1',
                'code' => '200',
                'data' => $results
            ];
    
            return response()->json($return);
        }
        
        $return['data'] = null;

        $return['message'] = 'So luong thuoc da het!';

        return response()->json($return);

    }

    public function detail(Request $request, $id)
    {
        $model = new Medicines_prescription;

        $Medicines_prescription =  $model->detail( $id);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicines_prescription
        ];
        return response()->json($return);
    }

    public function delete( $id)
    {
        
        $model = new Medicines_prescription;

        $model->deletev2($id);
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
        $model = new Medicines_prescription;

        $Medicines_prescription =$model->updatev2($arrayInput, $id);
        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $Medicines_prescription
        ];
        
        return response()->json($return);
    }
}
