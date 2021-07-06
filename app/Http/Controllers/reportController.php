<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\prescription;
use App\Prescriptions_detail;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use App\Variable;
use App\Medicine_inventory;
use App\Bill;

class reportController extends Controller
{
    public function reportMedicine(Request $request)
    {
        $model = new Medicine_inventory;

        $arrRequest = $request->all();

        $result = $model->report_medicine($arrRequest);

        $return = [
            'status' => '1',
            'code' => '200',
            'data' => $result
        ];

        return response()->json($return);
    }

    public function reportPrescription(Request $request)
    {
        $model = new Prescription;

        $arrRequest = $request->all();

        $result = $model->search($arrRequest);

        return response()->json($result);
    }
}
