<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Uses extends Model
{
    protected $table = 'uses';

    protected $fillable = [
        'id',
        'value',
        'created_at',
        'updated_at'
    ];

    public function Search(array $request){

        $model = $this;

        if(isset($request['id']) && $request['id']){
            $model = $model->where('id',$request['id']);
        }

        if(isset($request['value']) && $request['value']){
            $model = $model->where('value',$request['value']);
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
        
        $results = Uses::create($arrayInput);

        return $results;

    }

    public function detail( $id)
    {
        
        $Uses = Uses::where('id', $id)->first();

        return $Uses;
    }

    public function deletev2($id)
    {
        
        $Uses = Uses::where('id', $id)->first();

        return $Uses;
    }
    public function updatev2(Array $request, $id)
    {

        $arrayInput = [];

        if(isset($request['value']) && $request['value']){
            $arrayInput['value'] = $request['value'];
        }

        $Uses = Uses::where('id', $id)->first();
        
        $results = $Uses->update($arrayInput);
        
        return $results;
    }
}
