<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Symptom extends Model
{
    protected $table = 'symptoms';

    protected $fillable = [
        'disease_code',
        'symptom_code',
        'status',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['disease_code']) && $request['disease_code']){
            $model = $model->where('disease_code',$request['disease_code']);
        }

        if(isset($request['symptom_code']) && $request['symptom_code']){
            $model = $model->where('symptom_code',$request['symptom_code']);
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

        $arrayInput['status'] = 1; 
        
        $results = Symptom::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Symptom = Symptom::where('id', $id)->first();

        return $Symptom;
    }

    public function deletev2($id)
    {
        
        $Symptom = Symptom::where('id', $id)->first();

        $Symptom->update(['status'=>'2']);

        return $Symptom;
    }
    public function updatev2(Array $request)
    {

        $arrayInput = [];
        
        if(isset($request['disease_code']) && $request['disease_code']){
            $arrayInput['disease_code'] =$request['disease_code'];
        }

        if(isset($request['symptom_code']) && $request['symptom_code']){
            $arrayInput['symptom_code'] =$request['symptom_code'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}