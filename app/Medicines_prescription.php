<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Prescriptions_detail;
use App\Medicine;
class Medicines_prescription extends Model
{
    protected $table = 'medicines_prescriptions';

    protected $fillable = [
        'code',
        'medicine_code',
        'PD_code',
        'amount',
        'uses',
        'status',
        'cost_per_med',
        'created_at',
        'updated_at'
    ];

    public function prescription()
    {
        return $this->hasMany(Prescription::class,'customer_id','code');
    }

    public function medicine()
    {
        return $this->hasOne(Medicine::class,'code','medicine_code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['data_medicine']) && $request['data_medicine']){
            $model = $model->with('medicine');
        }

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code',$request['code']);
        }

        if(isset($request['medicince_code']) && $request['medicince_code']){
            $model = $model->where('medicince_code',$request['medicince_code']);
        }

        if(isset($request['PD_code']) && $request['PD_code']){
            $model = $model->where('PD_code','LIKE','%'.$request['PD_code'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['amount']) && $request['amount']){
            $model = $model->where('amount',$request['amount']);
        }

        if(isset($request['uses']) && $request['uses']){
            $model = $model->where('uses',$request['uses']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        $results = $model->get();

        return $results;
    }

    public function createv2(Array $request)
    {

        $code = $this->generateCode();

        $arrayInput = $request;

        $arrayInput['status'] = 1;

        $arrayInput['code'] = $code;

        $model_medicine = new Medicine;

        $price = $model_medicine->where('code',$request['medicine_code'])->first();

        $arrayInput['cost_per_med'] = $price->cost_per_med;
        
        DB::beginTransaction();
        
        try {

        $results = Medicines_prescription::create($arrayInput);

        $model_prescription_detail = new Prescriptions_detail;

        // update price prescription
        
        $prescription_detail = $model_prescription_detail->where('code',$request['PD_code'])->first();
        
        $medicine = $model_medicine->where('code',$request['medicine_code'])->first();
    
        $prescription_detail->updatev2([
            'price_medicines'=>$prescription_detail->price_medicines + $medicine->cost_per_med * $request['amount']
            ]);
            DB::commit();
        }   
        catch (\Throwable $th) {
            return $th;
        DB::rollBack();
        }
        
        return $results;

    }

    public function detail( $id)
    {
        
        $Medicines_prescription = Medicines_prescription::where('id', $id)->first();

        return $Medicines_prescription;
    }

    public function deletev2($id)
    {
        
        $Medicines_prescription = Medicines_prescription::where('id', $id)->first();

        $Medicines_prescription->update(['status'=>'2']);

        $model_prescription_detail = new Prescriptions_detail;

        $prescription_detail = $model_prescription_detail->where('code',$Medicines_prescription['PD_code'])->first();
        
        $prescription_detail->updatev2([
            'price_medicines'=> $prescription_detail->price_medicines - $Medicines_prescription->cost_per_med * $Medicines_prescription['amount']
            ]);

        return $Medicines_prescription;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];

        if(isset($request['medicine_code']) && $request['medicine_code']){
            $arrayInput['medicine_code'] = $request['medicine_code'];
        }

        if(isset($request['PD_code']) && $request['PD_code']){
            $arrayInput['PD_code'] =$request['PD_code'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] = $request['amount'];
        }

        if(isset($request['uses']) && $request['uses']){
            $arrayInput['uses'] = $request['uses'];
        }

        $this->update($arrayInput);
        
        return $this;
    }

    public function generateCode()
    { 
        $now =  Carbon::now();
        $model = $this->where('created_at','>',$now->startOfDay())->get();
        $id = '';
        if ($model) 
        {
            $postfix = count($model)+1;
            if ($postfix < 10)
                $id = "000". $postfix;
            else if ($postfix < 100)
                $id = "00". $postfix;
            else if ($postfix < 1000)
                $id = "0". $postfix;
        } 
        else
        {
            $id = "0001";
        }
        $stringCode = 240 .$now->format('ymd') . $id ;
        return $stringCode;
    }
}
