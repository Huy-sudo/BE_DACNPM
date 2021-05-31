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

class reportController extends Controller
{
    public function reportMedicine(Request $request)
    {
        $model = new Medicine_inventory;

        $arrRequest = $request->all();

        $result = $model->report_medicine($arrRequest);

        return response()->json($result);
    }
}
