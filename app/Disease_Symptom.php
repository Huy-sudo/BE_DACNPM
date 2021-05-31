<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Disease_Symptom extends Model
{
    protected $table='diseases_symptoms';

    protected $fillable = [
        'code',
        'symptom_name',
        'status',
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

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code','LIKE','%'.$request['code'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['symptom_name']) && $request['symptom_name']){
            $model = $model->where('symptom_name',$request['symptom_name']);
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
        $user_id = Auth::user()->id;

        $arrayInput = $request;
        
        $arrayInput['status'] = 1;
        
        $results = Disease_Symptom::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Disease_Symptom = Disease_Symptom::where('id', $id)->first();

        return $Disease_Symptom;
    }

    public function deletev2($id)
    {
        
        $Disease_Symptom = Disease_Symptom::where('id', $id)->first();
        $Disease_Symptom->update(['status'=>'2']);

        return $Disease_Symptom;
    }
    public function updatev2(Array $request)
    {

        $arrayInput = [];
        
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['symptom_name']) && $request['symptom_name']){
            $arrayInput['symptom_name'] =$request['symptom_name'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
