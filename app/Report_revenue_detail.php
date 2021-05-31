<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report_revenue_detail extends Model
{
    protected $table = 'report_revenue_detail';

    protected $fillable = [
        'id',
        'report_id',
        'day',
        'revenue',
        'status',
        'ratio',
        'customers',
        'created_at',
        'updated_at'
    ];

    public function report_revenue()
    {
        return $this->hasMany(Report_revenue::class,'id','report_id');
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

        if(isset($request['revenue']) && $request['revenue']){
            $model = $model->where('revenue',$request['revenue']);
        }

        if(isset($request['customers']) && $request['customers']){
            $model = $model->where('customers',$request['customers']);
        }

        if(isset($request['ratio']) && $request['ratio']){
            $model = $model->where('ratio',$request['ratio']);
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

        $arrayInput['day'] = Carbon::now()->day();

        $arrayInput['status'] = 1;

        $results = Report_revenue_detail::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Report_revenue_detail = Report_revenue_detail::where('id', $id)->first();

        return $Report_revenue_detail;
    }

    public function deletev2($id)
    {
        
        $Report_revenue_detail = Report_revenue_detail::where('id', $id)->first();

        $Report_revenue_detail->update(['status'=>'2']);

        return $Report_revenue_detail;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];
        
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['day']) && $request['day']){
            $arrayInput['day'] =$request['day'];
        }

        if(isset($request['customers']) && $request['customers']){
            $arrayInput['customers'] =$request['customers'];
        }

        if(isset($request['revenue']) && $request['revenue']){
            $arrayInput['revenue'] =$request['revenue'];
        }

        if(isset($request['ratio']) && $request['ratio']){
            $arrayInput['ratio'] =$request['ratio'];
        }

        $this->update($arrayInput);
        
        return $this;
    }
}
