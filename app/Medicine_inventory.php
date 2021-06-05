<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Medicine;        

use Carbon\Carbon;

class Medicine_inventory extends Model
{
    protected $table = 'medicines_inventory';

    protected $fillable = [
        'medicine_id',
        'type',
        'amount',
        'cost_per_med',
        'total',
        'in_stock_after',
        'created_at',
        'updated_at'
    ];

    public function prescription()
    {
        return $this->hasMany(Prescription::class,'customer_id','code');
    }

    public function medicine()
    {
        return $this->hasOne(Medicine::class,'id','medicine_id');
    }

    public function Search(array $request){

        $model = $this;

        if(isset($request['type']) && $request['type']){
            $model = $model->where('type',$request['type']);
        }

        if(isset($request['status']) && $request['status']){
            $model = $model->where('status',$request['status']);
        }

        if(isset($request['medicine_id']) && $request['medicine_id']){
            $model = $model->where('medicine_id','LIKE','%'.$request['medicine_id'].'%');
        }

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['amount']) && $request['amount']){
            $model = $model->where('amount',$request['amount']);
        }

        if(isset($request['total']) && $request['total']){
            $model = $model->where('total',$request['total']);
        }

        if(isset($request['in_stock_after']) && $request['in_stock_after']){
            $model = $model->where('in_stock_after',$request['in_stock_after']);
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
        
        DB::beginTransaction();
        
        try {
       
        $model_medicine = new Medicine;

        $medicine = $model_medicine->Search(['id'=>$request['medicine_id']]);

        $results['medicine'] = $medicine[0]->updatev2([
            'in_stock'=> $request['type'] == 1 ? $medicine[0]->in_stock + $request['amount'] : $medicine[0]->in_stock - $request['amount']
        ]);

        // $arrayInput['in_stock_after'] = $medicine[0]->in_stock;

        $results['Medicine_inventory'] = Medicine_inventory::create($arrayInput);

        DB::commit();
        } 
        catch (\Throwable $th) {
        DB::rollBack();
        }
        
        return $results;
    }

    public function detail( $id)
    {
        
        $Medicine_inventory = Medicine_inventory::where('id', $id)->first();

        return $Medicine_inventory;
    }

    public function deletev2($id)
    {
        
        $Medicine_inventory = Medicine_inventory::where('id', $id)->first();
        $Medicine_inventory->update(['status'=>'2']);

        return $Medicine_inventory;
    }

    public function updatev2(Array $request)
    {

        $arrayInput = [];
        if(isset($request['status']) && $request['status']){
            $arrayInput['status'] =$request['status'];
        }

        if(isset($request['medicince_id']) && $request['medicince_id']){
            $arrayInput['medicince_id'] =$request['medicince_id'];
        }

        if(isset($request['type']) && $request['type']){
            $arrayInput['type'] =$request['type'];
        }

        if(isset($request['amount']) && $request['amount']){
            $arrayInput['amount'] =$request['amount'];
        }

        $this->update($arrayInput);
        
        return $this;
    }

    public function report_medicine(Array $request)
    {

        $model = $this;

        $model = $model->with('medicine');

        if(isset($request['type']) && $request['type']){
            $model = $model->where('type',$request['type']);
        }

        if(isset($request['from_date']) && $request['from_date']){
            $from_date=Carbon::create($request['from_date'])->startOfDay();
            $model = $model->where('created_at','>',$from_date);
        }

        if(isset($request['to_date']) && $request['to_date']){
            $to_date=Carbon::create($request['to_date'])->endOfDay();
            $model = $model->where('created_at','<',$to_date);
        }

        $model->groupBy('medicine_id')->selectRaw('medicine_id, sum(amount) as total_amount, count(*) as total_uses');

        $result = $model->get();
        
        return $result;
    }
}
