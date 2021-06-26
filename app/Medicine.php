<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'id',
        'in_stock',
        'unit',
        'cost_per_med',
        'code',
        'created_at',
        'updated_at'
    ];

    public function medicinePrescription()
    {
        return $this->hasOne(Medicines_prescription::class,'medicine_code','code');
    }

    public function unit()
    {
        return $this->hasOne(Unit::class,'id','unit');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['code']) && $request['code']){
            $model = $model->where('code',$request['code']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['in_stock']) && $request['in_stock']){
            $model = $model->where('in_stock',$request['in_stock']);
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['unit']) && $request['unit']){
            $model = $model->where('unit',$request['unit']);
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $model = $model->where('cost_per_med',$request['cost_per_med']);
        }

        if(isset($request['name']) && $request['name']){
            $model = $model->where('name',$request['name']);
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

        $arrayInput = $request;

        $arrayInput['status'] = 1;

        $results = Medicine::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Medicine = Medicine::where('id', $id)
        ->with('unit')->first();

        return $Medicine;
    }

    public function deletev2($id)
    {
        
        $Medicine = Medicine::where('id', $id)->first();

        $Medicine->update(['status'=>'2']);

        return $Medicine;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] = $request['status'];
        }

        if(isset($request['in_stock']) && $request['in_stock']){
            $arrayInput['in_stock'] =$request['in_stock'];
        }

        if(isset($request['unit']) && $request['unit']){
            $arrayInput['unit'] = $request['unit'];
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $arrayInput['cost_per_med'] = $request['cost_per_med'];
        }

       $this->update($arrayInput);
        
        return $this;
    }
}
