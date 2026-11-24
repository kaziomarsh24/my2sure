<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\games;
use App\lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LotteryController extends Controller
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
         $validator = \Validator::make($request->all(), [
			'game_id' 	=> 'sometimes|nullable',
			'lottery' 	=> 'sometimes|nullable',
    		'from_date' 	=> 'sometimes|nullable|date',
    		'to_date' 		=> 'sometimes|nullable|date|after_or_equal:from_date',
    	]);

    	try
        {
        	if($validator->fails())
        	{
        		throw new ValidationException("Validation fails.");       		
        	}

        	if(!empty($request->from_date))
        	{
	        	$from_date 	= date('Y-m-d 00:00:00', strtotime($request->from_date ?? date('Y-m-d')));
	        	$to_date 	= date('Y-m-d 23:59:59', strtotime($request->to_date ?? date('Y-m-d')));
	        	$objLotteries = lottery::whereStatus('1')
					        	->where('created_at', '>=', $from_date)
					        	->where('created_at', '<=', $to_date);
			    if(!empty($request->game))
			    {
			    	$objLotteries = $objLotteries->where('game_id','like','%'.$request->game_id.'%');
			    }
			    if(!empty($request->lottery))
			    {
			    	$objLotteries = $objLotteries->where('name','like','%'.$request->lottery.'%');
			    }
	        	$objLotteries = $objLotteries->orderBy('game_id', 'DESC')->with(['game'])->get();
        	}else
        	{
	        	$objLotteries = lottery::whereStatus('1')->with(['game'])->get();
        	}
        	$objGames = games::whereStatus('1')->get();
            
	    	$data = [
	    		'objLotteries' 	=> $objLotteries,
	    		'objGames' 		=> $objGames,
	    		'pageTitle' 	=> "Lotteries",
	    	];
	        return view('admin.lottery.index')->with($data);
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

    public function show($id)
    {
        try
        {
            echo "No Show Method Til yet ";die();
        }catch(\Exception $e)
        {
            dd($e);
            report($e);
           return back()->withErrors($e) ->withInput();
        }
    }

    public function create()
    {
         try
        {
            $objGames      = games::whereStatus('1')->get();
            $passData = [
                "pageTitle"     => "Add New lottery",
                "objGames"     	=> $objGames,
            ];

            return view('admin.lottery.create')->with($passData);
        }catch(\Exception $e)
        {
            report($e);
           return back()->withErrors($e) ->withInput();
        }
    }

    public function edit($getId)
    {
         try
        {
            $objData = lottery::findOrFail($getId);
            $objGames = games::whereStatus('1')->get();
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objGames" => $objGames,
                "objData" => $objData,
            ];
            return view('admin.lottery.edit')->with($passData);
        }catch(\Exception $e)
        { 
            report($e);
            return back()->withErrors($e)
                        ->withInput();
        }
    }
 

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'game_id'   	=> 'required',
            'name' 			=> 'required',
            'permutation' 	=> 'required',
            'starting_no' 	=> 'required',
            'one_time' 		=> 'required',
            'sets' 			=> 'required',
            'status' 		=> 'required',
        ];
        $reqFields = ['game_id','name','permutation','starting_no','one_time','sets','status' ];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");             
            }
            $inputData = $request->all($reqFields);
            DB::beginTransaction();
            $obj = new lottery($inputData);

            $obj->save();

            DB::commit();

            return redirect()->route('admin.lottery.index');

        }catch(\ValidationException $e)
        {
            DB::rollBack();
            report($e);
            return back()->withErrors($e)
                        ->withInput();
        }catch(\Exception $e)
        {
            DB::rollBack();
            dd($e);
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
    public function update($id ,Request $request)
    {
        $data = [
            'game_id'   	=> 'required',
            'name' 			=> 'required',
            'permutation' 	=> 'required',
            'starting_no' 	=> 'required',
            'one_time' 		=> 'required',
            'sets' 			=> 'required',
            'status' 		=> 'required',
        ];
        $reqFields = [ 'game_id','name','permutation','starting_no','one_time','sets','status' ];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");             
            }
            $inputData = $request->all($reqFields);
            $objData = lottery::findOrFail($id);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->game_id 		= $inputData['game_id'];
            $objData->name 			= $inputData['name'];
            $objData->permutation 	= $inputData['permutation'];
            $objData->starting_no 	= $inputData['starting_no'];
            $objData->one_time 		= $inputData['one_time'];
            $objData->sets 			= $inputData['sets'];
            $objData->status 		= $inputData['status'];
            $objData->save();
            DB::commit();
            return redirect()->route('admin.lottery.index');

        }catch(ValidationException $e)
        {
            DB::rollBack();
            report($e);
           return back()->withErrors($e)
                        ->withInput();
        }catch(\Exception $e)
        {
            DB::rollBack();
            report($e);
            return back()->withErrors($e)
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($getId)
    { 
        try
        {
            if(!isset($getId))
            {
                throw new \ValidationException("Validation fails.");             
            }

            $objData = lottery::findOrFail($getId);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->delete();

            DB::commit();
            return redirect()->route('admin.lottery.index');

        }catch(\ValidationException $e)
        {
            DB::rollBack();
            report($e);
            return response()->json("Please Fill All required Fields.", 500);
        }catch(\Exception $e)
        {
            DB::rollBack();
            report($e);
            return response()->json("Something Went Wrong. Please Try Again.", 500);
        }
    }

     
}
