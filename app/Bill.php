<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'code',
        'status',
        'PD_code',
        'total_price',
        'analysis_price',
        'created_at',
        'updated_at'
    ];

    public function prescription_detail()
    {
        return $this->hasMany(Prescription::class,'PD_code','code');
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

        if(isset($request['PD_code']) && $request['PD_code']){
            $model = $model->where('PD_code',$request['PD_code']);
        }

        if(isset($request['total_price']) && $request['total_price']){
            $model = $model->where('total_price',$request['total_price']);
        }

        if(isset($request['analysis_price']) && $request['analysis_price']){
            $model = $model->where('analysis_price',$request['analysis_price']);
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

        $arrayInput = $request;
        
        $arrayInput['status'] = 1;

        $arrayInput['code'] = $code;
        
        $results = Bill::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Bill = Bill::where('id', $id)->first();

        return $Bill;
    }

    public function deletev2($id)
    {
        
        $Bill = Bill::where('id', $id)->first();

        $Bill->update(['status'=>'2']);

        return $Bill;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['analysis_price']) && $request['analysis_price']){
            $arrayInput['analysis_price'] =$request['analysis_price'];
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

