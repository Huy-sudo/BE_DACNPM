<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Import_medicine extends Model
{
    protected $table = 'import_medicines';

    protected $fillable = [
        'id',
        'total',
        'date',
        'status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function import_medicine_detail()
    {
        return $this->hasMany(Import_medicine_detail::class,'import_id','id');
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

        if(isset($request['total']) && $request['total']){
            $model = $model->where('total',$request['total']);
        }

        if(isset($request['date']) && $request['date']){
            $model = $model->where('date',$request['date']);
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
        
        $arrayInput['date'] = Carbon::now();

        $arrayInput['status'] = 1;

        $results = Import_medicine::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Import_medicine = Import_medicine::where('id', $id)->first();

        return $Import_medicine;
    }

    public function deletev2($id)
    {
        
        $Import_medicine = Import_medicine::where('id', $id)->first();

        $Import_medicine->update(['status'=>'2']);

        return $Import_medicine;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];

        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['total']) && $request['total']){
            $arrayInput['total'] =$request['total'];
        }

        if(isset($request['user_id']) && $request['user_id']){
            $arrayInput['user_id'] =$request['user_id'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
