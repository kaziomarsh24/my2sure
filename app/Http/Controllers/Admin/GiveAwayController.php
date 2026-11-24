<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\giveaway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GiveAwayController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->objUser = \Auth::user();
            if($this->objUser->type != "admin")
            {
                $getStatus = "LIMITED ACCESS";
                $getMessage = "<h3>".$this->objUser->name."</h3>
                 Its Seems You dont have access to this page <br/>   ";
                return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
            }
            return $next($request);
        });

    }

    public function index(Request $request)
    { 

        try
        { 
            $obj = DB::table('giveawayplan')->get();
            
            $data = [
                'obj'      => $obj,
                'pageTitle'     => "Points Setting",
            ];
            return view('admin.giveaway.index')->with($data);
        }
        catch(ValidationException $e)
        {
            return back()->withErrors($validator)
                        ->withInput();
        }
        catch(\Exception $e)
        {
            report($e);
            return abort(500, "Something Went Wrong. Please Try Again.");
        }
    }



    public function edit($getId)
    {
         try
        {
            $objData = giveaway::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.giveaway.edit')->with($passData);
        }catch(\Exception $e)
        { 
            report($e);
            return back()->withErrors($e)
                        ->withInput();
        }
    }
 

    



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $data = [  
            'value'          => 'required',
            
        ];
        
        DB::table('giveawayplan')
        ->where('id', $request->id) // find your user by their email
        ->update(array('value' => $request->value)); // update the record in the DB.
        
        $data=DB::table('giveawayadd')->where('date',DATE('Y-m-d'))->get();
        
        
        foreach($data as $d)
        {
            $point=$this->getpoint($d->value);
            $point2=$this->getpoint($d->value2);
            $points=$point+$point2;
            
            
            DB::table('giveawayadd')
            ->where('id', $d->id)
            ->update(array('points' => $points)); 
            
        }
        
        
        
        
        return redirect()->route('admin.giveaway.index');
    }
    
    
    private function getpoint($value)
    {
        $todayday= date("l");
        $points="";
        $plans=DB::table('giveawayplan')->get();
        foreach($plans as $plan)
        {
            if($plan->day==$todayday)
            {
                $array = explode(',', $plan->value);
                array_unshift($array,"");
                unset($array[0]);
                
                
                $k = array_search($value, $array);
                if($k >= 1 )
                {
                    if($k == 1)
                    {
                      $points=10;   
                    }
                    if($k == 2)
                    {
                      $points=8;   
                    }
                    if($k == 3)
                    {
                      $points=6;   
                    }
                    if($k == 4)
                    {
                      $points=4;   
                    }
                    if($k == 5)
                    {
                      $points=2;   
                    }
                }
                else
                {
                  $points=0;   
                }
            }
        }
        
        return $points;
    }

     
}
