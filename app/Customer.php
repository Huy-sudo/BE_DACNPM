<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Prescription;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'code',
        'name',
        'sex',
        'birth',
        'status',
        'phone',
        'address',
        'created_at',
        'updated_at'
    ];

    public function prescription()
    {
        return $this->hasMany(Prescription::class,'customer_id','code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['name']) && $request['name']){
            $model = $model->where('name','LIKE','%'.$request['name'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code',$request['code']);
        }

        if(isset($request['sex']) && $request['sex']){
            $model = $model->where('sex',$request['sex']);
        }

        if(isset($request['phone']) && $request['phone']){
            $model = $model->where('phone',$request['phone']);
        }

        if(isset($request['birth']) && $request['birth']){
            $model = $model->where('birth',$request['birth']);
        }

        if(isset($request['address']) && $request['address']){
            $model = $model->where('address',$request['address']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        $sorted = $model->orderBy('created_at', 'desc');

        $results = $sorted->get();

        return $results;
    }

    public function createv2(Array $request)
    {

        $code = $this->generateCode();

        $user_id = Auth::user()->id;

        $arrayInput = $request;
        
        $arrayInput['status'] = 1;
        
        $arrayInput['code'] = $code;

        $arrayInput = array_merge($arrayInput,$request);
        
        $results = Customer::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Customer = Customer::where('id', $id)->first();

        return $Customer;
    }

    public function deletev2($id)
    {
        
        $Customer = Customer::where('id', $id)->first();

        $Customer->update(['status'=>'2']);

        return $Customer;
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

        if(isset($request['phone']) && $request['phone']){
            $arrayInput['phone'] =$request['phone'];
        }

        if(isset($request['birth']) && $request['birth']){
            $arrayInput['birth'] =$request['birth'];
        }

        if(isset($request['address']) && $request['address']){
            $arrayInput['address'] =$request['address'];
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
        $stringCode = 220 .$now->format('ymd') . $id ;
        return $stringCode;
    }
}
