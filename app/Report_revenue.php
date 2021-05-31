<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Report_revenue extends Model
{
    protected $table = 'report_revenue';

    protected $fillable = [
        'id',
        'month',
        'year',
        'revenue',
        'status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function report_revenue_detail()
    {
        return $this->hasMany(Report_revenue_detail::class,'report_id','id');
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

        if(isset($request['month']) && $request['month']){
            $model = $model->where('month',$request['month']);
        }

        if(isset($request['year']) && $request['year']){
            $model = $model->where('year',$request['year']);
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

        $arrayInput['month'] = Carbon::now()->month();

        $arrayInput['year'] = Carbon::now()->year();

        $arrayInput['status'] = 1;

        $results = Report_revenue::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Report_revenue = Report_revenue::where('id', $id)->first();

        return $Report_revenue;
    }

    public function deletev2($id)
    {
        
        $Report_revenue = Report_revenue::where('id', $id)->first();

        $Report_revenue->update(['status'=>'2']);

        return $Report_revenue;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];
        
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['year']) && $request['year']){
            $arrayInput['year'] =$request['year'];
        }

        if(isset($request['month']) && $request['month']){
            $arrayInput['month'] =$request['month'];
        }

        if(isset($request['revenue']) && $request['revenue']){
            $arrayInput['revenue'] =$request['revenue'];
        }

        if(isset($request['user_id']) && $request['user_id']){
            $arrayInput['user_id'] =$request['user_id'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
