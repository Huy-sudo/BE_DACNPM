<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Import_medicine_detail extends Model
{
    protected $table = 'import_medicine_detail';

    protected $fillable = [
        'id',
        'import_id',
        'medicine_code',
        'amount',
        'cost_per_med',
        'total_amount',
        'status',
        'created_at',
        'updated_at'
    ];

    public function import_medicine()
    {
        return $this->hasOne(Import_medicine::class,'id','import_id');
    }

    public function medicine()
    {
        return $this->hasOne(Medicine::class,'id','code','medicine_code');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['medicine_code']) && $request['medicine_code']){
            $model = $model->where('medicine_code',$request['medicine_code']);
        }

        if(isset($request['total_amount']) && $request['total_amount']){
            $model = $model->where('total_amount',$request['total_amount']);
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $model = $model->where('cost_per_med',$request['cost_per_med']);
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

        $results = Import_medicine_detail::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Import_medicine_detail = Import_medicine_detail::where('id', $id)->first();

        return $Import_medicine_detail;
    }

    public function deletev2($id)
    {
        
        $Import_medicine_detail = Import_medicine_detail::where('id', $id)->first();

        $Import_medicine_detail->update(['status'=>'2']);

        return $Import_medicine_detail;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];

        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['cost_per_med']) && $request['cost_per_med']){
            $arrayInput['cost_per_med'] =$request['cost_per_med'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] =$request['amount'];
        }

        if(isset($request['import_id']) && $request['import_id']){
            $arrayInput['import_id'] =$request['import_id'];
        }   

        if(isset($request['medicine_code']) && $request['medicine_code']){
            $arrayInput['medicine_code'] =$request['medicine_code'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
