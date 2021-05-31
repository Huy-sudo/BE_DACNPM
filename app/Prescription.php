<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Prescription extends Model
{
    protected $table = 'prescriptions';

    protected $model;

    protected $fillable = [
        'id',
        'code',
        'status',
        'customer_id',
        'user_id',
        'date',
        'symptoms',
        'diseases',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function prescriptionDetail()
    {
        return $this->hasOne(Prescriptions_detail::class,'prescription_id','id');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        if(isset($request['today']) && $request['today'] == 1){
            $now = Carbon::now();
            $model = $model->where('created_at','>',$now->startOfDay());
        }

        if(isset($request['data_customer']) && $request['data_customer'] ){
            $model = $model->with('customer');
        }
        
        $model = $model->with('prescriptionDetail.medicine');
        
        $results = $model->get();
        
        return $results;
    }

    public function createv2(Array $request)
    {

        $code = $this->generateCode();

        $user_id = Auth::user()->id;

        $arrayInput = $request;

        $arrayInput['code'] = $code;

        $arrayInput['status'] = 1;

        $arrayInput['user_id'] = $user_id;

        $arrayInput = array_merge($arrayInput,$request);

        $results =$this::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $prescription = prescription::where('id', $id)
        ->with('user')
        ->with('prescriptionDetail.medicine.medicine')
        ->with('prescriptionDetail.bill')
        ->with('customer')->first();

        return $prescription;
    }

    public function deletev2($id)
    {
        
        $prescription = prescription::where('id', $id)->first();

        $prescription->update(['status'=>'2']);

        return $prescription;
    }
    
    public function updatev2(Array $request)
    {

        $arrayInput = [];
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['name']) && $request['name']){
            $arrayInput['name'] =$request['name'];
        }

        if(isset($request['sex']) && $request['sex']){
            $arrayInput['sex'] =$request['sex'];
        }

        if(isset($request['birth']) && $request['birth']){
            $arrayInput['birth'] =$request['birth'];
        }

        if(isset($request['address']) && $request['address']){
            $arrayInput['address'] =$request['address'];
        }

        if(isset($request['phone']) && $request['phone']){
            $arrayInput['phone'] =$request['phone'];
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
        $stringCode = 120 .$now->format('ymd') . $id ;
        return $stringCode;
    }
}

