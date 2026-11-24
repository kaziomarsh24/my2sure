<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->settings = app()->make("objSetting");
        $this->middleware(function ($request, $next) {

            $this->objUser = \Auth::user();

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['settings'=>$this->settings]);
    }

     public function enableTrial(Request $request)
    {
        if($this->objUser->trial_used == 1)
        {

            if($this->objUser->expiry_date < date('Y-m-d'))
            {
                $getStatus = "your Trial Period is Expired";
                $getMessage = "<h3>".$this->objUser->name."</h3>
                 Your Current Trial Period for <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> is Expired on <b>".$this->objUser->expiry_date." </b><br/>
                 You cannot Play any Forecaster until you Purchased or Renew Your Subscription
                  <br/>
                  <br/>
                  <a href='".route('client.payWithPaypal')."' class='btn btn-md btn-success'><i class='fa fa-paypal'></i> Purchase ".$this->settings->firstWhere('name', 'sub_name')->detail." for ".$this->settings->firstWhere('name', 'sub_price')->detail."</a> ";
            }else
            {
                $getStatus = "You Already on your Trial Period";
                $getMessage = "<h3>".$this->objUser->name."</h3>
                 Your Current Trial Period for <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> is Already Active and will be expired at <b>".$this->objUser->expiry_date." </b><br/>

                  <br/>
                  <br/>
                  <a href='".route('client.games.index')."' class='btn btn-md btn-success'>Browse All Games </a> ";
            }

                return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
        }

        $objData = User::where('id',$this->objUser->id)->update(['trial_used' => 1,'expiry_date' => date('Y-m-d',strtotime(date('Y-m-d')." +1 day")) ]);
        $getStatus = "Your Trial Period Is Active ";
        $getMessage = "<h3>".$this->objUser->name."</h3>
                 Your Trial Period is Active for  <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Will be Expired in Next Day<br/>

                  <br/>
                  <br/>
                  <a href='".route('client.games.index')."' class='btn btn-md btn-success'>Browse All Games </a> ";
                return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
    }
}
