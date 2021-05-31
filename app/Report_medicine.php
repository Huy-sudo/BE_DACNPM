<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Report_medicine extends Model
{
    protected $table = 'report_medicine';

    protected $fillable = [
        'id',
        'day',
        'month',
        'year',
        'medicine_code',
        'amount',
        'times',
        'status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function medicine()
    {
        return $this->hasMany(Medicine::class,'code','medicine_code');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['day']) && $request['day']){
            $model = $model->where('day',$request['day']);
        }

        if(isset($request['month']) && $request['month']){
            $model = $model->where('month',$request['month']);
        }

        if(isset($request['year']) && $request['year']){
            $model = $model->where('year',$request['year']);
        }

        if(isset($request['medicine_code']) && $request['medicine_code']){
            $model = $model->where('medicine_code',$request['medicine_code']);
        }

        if(isset($request['user_id']) && $request['user_id']){
            $model = $model->where('user_id',$request['user_id']);
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

        $user_id = Auth::user()->id;

        $arrayInput['user_id'] = $user_id;

        $arrayInput['day'] = Carbon::now()->day();

        $arrayInput['month'] = Carbon::now()->month();

        $arrayInput['year'] = Carbon::now()->year();

        $arrayInput['status'] = 1;

        $results = Report_medicine::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Report_medicine = Report_medicine::where('id', $id)->first();

        return $Report_medicine;
    }

    public function deletev2($id)
    {
        
        $Report_medicine = Report_medicine::where('id', $id)->first();

        $Report_medicine->update(['status'=>'2']);

        return $Report_medicine;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];

        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] =$request['amount'];
        }

        if(isset($request['times']) && $request['times']){
            $arrayInput['times'] =$request['times'];
        }

        if(isset($request['medicine_code']) && $request['medicine_code']){
            $arrayInput['medicine_code'] =$request['medicine_code'];
        }

        if(isset($request['user_id']) && $request['user_id']){
            $arrayInput['user_id'] =$request['user_id'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
