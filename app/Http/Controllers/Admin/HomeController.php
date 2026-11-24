<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\games;
use App\lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        $validator = Validator::make($request->all(), [
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
	    		'pageTitle' 	=> "Dashboard",
	    	];
	        return view('admin.dashboard.index')->with($data);
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

     
}
