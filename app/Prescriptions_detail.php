<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\Prescription;
use App\Medicines_prescription;
use App\Medicine;

class Prescriptions_detail extends Model
{
    //status: 1 - pending, 2 - completed, 3 - cancel
    protected $table = 'prescriptions_details';
    
    protected $fillable = [
        'id',
        'code',
        'prescription_id',
        'price_medicines',
        'status',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
    public function prescription()
    {
        return $this->hasOne(Prescription::class,'id','prescription_id');
    }

    public function medicine()
    {
        return $this->hasmany(Medicines_prescription::class,'PD_code','code')->where('status',1);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class,'PD_code','code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['data_customer']) && $request['data_customer'] == 1){
            $model = $model->with('customer');
        }

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code',$request['code']);
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['prescription_id']) && $request['prescription_id']){
            $model = $model->where('prescription_id',$request['prescription_id']);
        }

        if(isset($request['price_medicine']) && $request['price_medicine']){
            $model = $model->where('price_medicine',$request['price_medicine']);
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

        $user_id = Auth::user()->id;

        $arrayInput = $request;

        $arrayInput['status'] = 1; //pending

        $arrayInput['code'] = $code;

        $results = Prescriptions_detail::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Prescriptions_detail = Prescriptions_detail::where('id', $id)->with('medicine.unit')->with('bill')->with('customer')->first();

        return $Prescriptions_detail;
    }

    public function deletev2($id)
    {
        
        $Prescriptions_detail = Prescriptions_detail::where('id', $id)->first();
        
        $Prescriptions_detail->update(['status'=>'2']);

        return $Prescriptions_detail;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];

        $medicine_inventory = new Medicine_inventory;
        
        $model_medicine = new Medicine;

        if(isset($request['status']) && $request['status'] == 2){
            $arrayInput['status'] = $request['status'];
            
            $medicines = $this->medicine()->get();

            foreach ($medicines as $key => $element) {

                $medicine = $model_medicine->where('code',$element->medicine_code)->first();

                $inputs = [
                    'medicine_id' => $medicine->id,
                    'amount' => $element->amount,
                    'type' => 2
                ];
                $medicine_inventory->createv2($inputs);
            }
        }

        if(isset($request['price_medicines']) && $request['price_medicines']){
            $arrayInput['price_medicines'] = $request['price_medicines'];
        }
        $this->update($request);

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
        $stringCode = 140 .$now->format('ymd') . $id ;
        return $stringCode;
    }
}
