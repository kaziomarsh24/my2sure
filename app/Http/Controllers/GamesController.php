<?php

namespace App\Http\Controllers;

use DateTime;
use App\User;
use App\forecasterPlay;
use App\games;
use App\lottery;
use App\plans;
use App\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;
use App\Post;


class GamesController extends Controller
{
   public $free_mode=0;
   public $two_sure_free_mode=0;
   public $all_games_free_mode=0;

    public function __construct()
    {
        global $free_mode;
        global $two_sure_free_mode;
        global $all_games_free_mode;
        $this->settings = app()->make("objSetting");

        $collection = collect(json_decode($this->settings, true));

        $free_mode = $collection->where('name', 'free_mode')->pluck('detail')->first();
        $two_sure_free_mode = $collection->where('name', 'two_sure_free_mode')->pluck('detail')->first();
        $all_games_free_mode = $collection->where('name', 'all_games_free_mode')->pluck('detail')->first();

        $this->middleware(function ($request, $next) {

            global $free_mode;
            global $two_sure_free_mode;

            $this->objUser = Auth::user();

            if($this->objUser != null)
            {
                if($this->objUser->isActive != "1")
                {
                    //IS Site In Free Mode
//                    if($two_sure_free_mode ==1){
//
//                    if($this->objUser->expiry_date < date('Y-m-d'))
//                    {
//                        $getStatus = "your Trial Period is Expired";
//                        $getMessage = "<h3>".$this->objUser->name."</h3>
//                         DDYour Current Trial Period for <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> is Expired on <b>".$this->objUser->expiry_date." </b><br/>
//                         You cannot Play any Forecaster until you Purchased or Renew Your Subscription
//                          <br/>
//                          <br/>
//                          <a href='".route('client.payWithPaypal')."' class='btn btn-md btn-success'><i class='fa fa-paypal'></i> Purchase ".$this->settings->firstWhere('name', 'sub_name')->detail." for $".$this->settings->firstWhere('name', 'sub_price')->detail."</a> ";
//
//                        return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
//                    }else if(date('Y-m-d') <= $this->objUser->expiry_date)
//                    {
//
//                    }else
//                    {
//                        $getStatus = "No Subscription Found";
//                        $getMessage = "<h3>".$this->objUser->name."</h3>
//                         Its Seems you didn't Successfully purchased any Subscription  yet <br/> Please Proceed with any of Subscription and Get Full Access of Lottery Forecaster Games Library and Get 95% chances to win the Next Lottery. <br/>   ";
//                        $getMessage .= '<a class="btn btn-lg btn-success cBtn" href="'.route("client.payWithPaypal").'"><i class="fa fa-paypal"></i> Purchase  '.$this->settings->firstWhere("name", "sub_name")->detail.' For $'.$this->settings->firstWhere("name", "sub_price")->detail.' </a>';
//                        return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
//                    }
//
//                    }
                }
            }
            return $next($request);
        });
    }
    public function index()
    {
        // All Games listing is open to everyone. Monetization happens on the
        // individual game page via the "Choose For Me" subscription gate.
        $objLotteries = lottery::whereStatus('1')->with(['game'])->get();
        $data = [
            'settings'      => $this->settings,
            'objLotteries'  => $objLotteries,
        ];
        return view('client.games.all')->with($data);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function giveaway()
    {
        // IS User Can Play
        if($this->objUser != null)
        {
            global $free_mode; //0=free, 1=paid
            global $two_sure_free_mode; //0=free, 1=paid

            //IS Site IN Free Mode
            if($two_sure_free_mode == 1) {

                if ($this->objUser->expiry_date < date('Y-m-d')) {
                    $days = (int)((strtotime($this->objUser->trial_used_date) - strtotime(date('Y-m-d'))) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day

                    // if($this->objUser->trial_used == 0)
                    if ($this->objUser->trial_used == 5) {
                        $getStatus = "ENJOY 1 DAY FREE PREMIUM FORECAST ";
                        $getMessage = "<h3>" . $this->objUser->name . "</h3>
                         Your Current Subscription <b>" . $this->settings->firstWhere('name', 'sub_name')->detail . "</b> is Expired on <b>" . $this->objUser->expiry_date . " </b><br/>
                         To enjoy you 1 day trial of " . $this->settings->firstWhere('name', 'sub_name')->detail . " please click below
                          <br/>
                          <br/>
                          <a href='" . route('client.enableTrial') . "' class='btn btn-md btn-success'><i class='fa fa-paypal'></i> Enable My Trial For " . $this->settings->firstWhere('name', 'sub_name')->detail . " </a>
                          <br/>
                          <a href='" . route('client.payWithPaypal') . "' class='btn btn-md btn-success'><i class='fa fa-paypal'></i> Purchase " . $this->settings->firstWhere('name', 'sub_name')->detail . " for $" . $this->settings->firstWhere('name', 'sub_price')->detail . "</a>

                           ";
                        return redirect()->route('client.redirectPayment', ['status' => $getStatus, "msg" => $getMessage]);

                    } else {

                        $getStatus = "your Subscription Expired";
                        if ($this->objUser->trial_used == 1) {
                            $getStatus = "Your Trial Period Expired - Purchase the Subscription";
                        }

                        $getMessage = "<h3>" . $this->objUser->name . "</h3>
                         Your Current Subscription <b>" . $this->settings->firstWhere('name', 'sub_name')->detail . "</b> is Expired on <b>" . $this->objUser->expiry_date . " </b><br/>
                         You cannot Play any Forecaster until you Purchased or Renew Your Subscription
                          <br/>
                          <br/>
                          <a href='" . route('client.payWithPaypal') . "' class='btn btn-md btn-success'><i class='fa fa-paypal'></i> Purchase " . $this->settings->firstWhere('name', 'sub_name')->detail . " for $" . $this->settings->firstWhere('name', 'sub_price')->detail . "</a> ";

                        return redirect()->route('client.redirectPayment', ['status' => $getStatus, "msg" => $getMessage]);

                    }

                }
            }
        }
        // IS User Can Play
        $current_day = date("D");

        $game_id=22;

        $titles = DB::table('title')->where('id','1')->first();
        $objGame = DB::table('games')->where('id',$game_id)->first();

        if($this->objUser != null)
        {
            $objValues =DB::table('giveawayadd')->where('user_id',$this->objUser->id)->where('date',DATE('Y-m-d'))->first();

            $values=array();
            if($objValues != null)
            {
                $values[]=$objValues->value;
                $values[]=$objValues->value2;
            }
        }
        else
        {
            $values=array();
        }

        $objSliders =DB::table('slider')->get();

        // date_default_timezone_set("Asia/Karachi");
        $current_time = date("h:i a");


        $collection = collect(json_decode($this->settings, true));
        $time_restriction = $collection->where('name', 'giveaway_time_restriction')->pluck('detail')->first();

        if ($time_restriction == '0') {
            // Restriction OFF — always allow
            $playbit = 1;
        } else {
            // Restriction ON — check 6am to 7pm
            $sunrise = "06:00 am";
            $sunset  = "7:00 pm";
            $date1   = DateTime::createFromFormat('h:i a', $current_time);
            $date2   = DateTime::createFromFormat('h:i a', $sunrise);
            $date3   = DateTime::createFromFormat('h:i a', $sunset);

            if ($date1 > $date2 && $date1 < $date3) {
                $playbit = 1;
            } else {
                $playbit = 0;
            }
        }




        // if (date('H') < 21)
        // {
        //     $objUsers =DB::table('giveawayadd')
        //     ->select('giveawayadd.user_id','users.name',DB::raw("SUM(points) as totalpoints"))
        //     ->join('users', 'users.id', '=', 'giveawayadd.user_id')
        //     ->orderBy('totalpoints','Desc')
        //     ->groupBy('giveawayadd.user_id','users.name')
        //     ->where('date','!=',DATE('Y-m-d'))
        //     ->get();

        // }
        // else
        // {
        //     $objUsers =DB::table('giveawayadd')
        //     ->select('giveawayadd.user_id','users.name',DB::raw("SUM(points) as totalpoints"))
        //     ->join('users', 'users.id', '=', 'giveawayadd.user_id')
        //     ->orderBy('totalpoints','Desc')
        //     ->groupBy('giveawayadd.user_id','users.name')
        //     ->get();
        // }

//
        // dd($objGame->last_end_date, $objGame->end_date);

        $objUsers =DB::table('giveawayadd')
            ->select('giveawayadd.user_id','users.name',DB::raw("SUM(points) as totalpoints"))
            ->join('users', 'users.id', '=', 'giveawayadd.user_id')
            ->whereBetween('giveawayadd.date', [$objGame->last_end_date, $objGame->end_date])
            ->orderBy('totalpoints','Desc')
            ->groupBy('giveawayadd.user_id','users.name')
            ->get();


        $slug="test-for-comment-system";
        $post = Post::where('slug', $slug)->first();

        $data = [
            'settings'      => $this->settings,
            'objGame'       => $objGame,
            'objValues'       => $values,
            'objUsers'       => $objUsers,
            'playbit'       => $playbit,
            'current_time'       => $current_time,
            'current_day'       => $current_day,
            'titles'       => $titles,
            'post'       => $post,
        ];



        return view('client.games.giveaway')->with($data);
    }
    public function giveawaydetail($id)
    {
        $objGame = DB::table('games')->where('id','22')->first();


        if (date('H') < 21)
        {
            $objPoints =DB::table('giveawayadd')
                ->where('user_id',$id)
                ->where('date','!=',DATE('Y-m-d'))
                ->orderBy('giveawayadd.id','Desc')
                ->get();

        }
        else
        {
            $objPoints =DB::table('giveawayadd')
                ->where('user_id',$id)
                ->orderBy('giveawayadd.id','Desc')
                ->get();
        }

        $data = [
            'settings'      => $this->settings,
            'objPoints'       => $objPoints,
            'objGame'       => $objGame,
        ];



        return view('client.games.giveawaydetail')->with($data);
    }
    public function giveawayadd(Request $request)
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
                 $k = array_search($request->id, $array);
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

        $check=DB::table('giveawayadd')->where('user_id',$this->objUser->id)->where('value',$request->id)->where('date',DATE('Y-m-d'))->first();

        $check1=DB::table('giveawayadd')->where('user_id',$this->objUser->id)->where('value2',$request->id)->where('date',DATE('Y-m-d'))->first();

        $check2=DB::table('giveawayadd')->where('user_id',$this->objUser->id)->where('date',DATE('Y-m-d'))->count();

        if($check == null && $check1 == null && $check2 <= 1)
        {

            if($check2 == 0)
            {
                DB::table('giveawayadd')->insert([
                    'user_id' => $this->objUser->id,
                    'value' => $request->id,
                    'date' => DATE('Y-m-d'),
                     'points' => $points,
                ]);
            }

            if($check2 == 1)
            {
                $data=DB::table('giveawayadd')->where('user_id',$this->objUser->id)->where('date',DATE('Y-m-d'))->first();


                DB::table('giveawayadd')
                    ->where('id', $data->id)
                    ->limit(1)
                    ->update([
                        'value2' => $request->id,
                         'points' => $points + $data->points
                    ]);

            }

            return;
        }
    }
    public function show($id)
    {
        // The game page itself is open to everyone; the "Choose For Me" action
        // is what requires an active All Games subscription (see $canChoose below).
        $objGame = lottery::whereId($id)->with(['game'])->first();

        $game_view='g1_view';
        if($objGame->game_id==5){
            $game_view='g1_view';
        }else if ($objGame->game_id==6){
            $game_view='g2_view';
        }else if ($objGame->game_id==7){
            $game_view='g3_view';
        }else if ($objGame->game_id==8){
            $game_view='g4_view';
        }else if ($objGame->game_id==9){
            $game_view='g5_view';
        }else if ($objGame->game_id==18){
            $game_view='g6_view';
        }else{
            $game_view='g1_view';
        }

        $objPlans1 = plans::where('sets', $objGame->permutation)->where('status', '1')->where($game_view, '0')->get();

        if ($objPlans1->count() == 0) {

            plans::where('sets', $objGame->permutation)->where('status', '1')->update([$game_view => 0]);
        }

        $objPlans = plans::select('numbers')->where('sets',$objGame->permutation)->where('status','1')->get()->toArray();

        $selected = plans::select('numbers','id')->where('sets',$objGame->permutation)->where('status','1')->where($game_view, '0')->take($objGame->sets)->get()->toArray();

        $selected_number = array();

        foreach ($selected as $key => $value) {
            $selected_number[$key] = $value['numbers'];
            plans::where('id', $value['id'])->where('sets', $objGame->permutation)->where('status', '1')->where($game_view, '0')->update([$game_view => 1]);
        }

        $winnerCount = \App\Winner::where('user_id', $this->objUser->id)->count();

        $isWinner = $winnerCount > 0;

        $baseRewardAmount = collect(json_decode($this->settings, true))
            ->where('name', 'reward_amount')
            ->pluck('detail')
            ->first() ?? '10';

        $rewardAmount = $baseRewardAmount * $winnerCount;

        // "Choose For Me" gate: free when all_games_mode is off, otherwise an
        // active all_games subscription is required. Browsing all games and the
        // individual game page (Use Now) stay free either way.
        $allGamesMode = $this->settings->firstWhere('name', 'all_games_mode')->detail ?? '0';
        $canChoose = ($allGamesMode == '0')
            || \App\Subscription::isActive($this->objUser->id, 'all_games');

        $data = [
            'settings'        => $this->settings,
            'objPlans'        => $objPlans,
            'objGame'         => $objGame,
            'selected_number' => json_encode($selected_number),
            'isWinner'        => $isWinner,
            'rewardAmount'    => $rewardAmount,
            'canChoose'       => $canChoose,
        ];

        return view('client.games.index')->with($data);
    }
    public function edit(games $games)
    {
        //
    }
    public function update(Request $request, games $games)
    {
        //
    }
    public function destroy(games $games)
    {
        //
    }
    public function savePlay(Request $request)
    {
        DB::beginTransaction();
        $data = [
            'numbers' => implode("/", $request->get("numbers")),
            'lottery_id' => $request->get("gameId"),
            'user_id' => $this->objUser->id,
            'game_name' => $request->game_name,
        ];
        $obj = new forecasterPlay($data);
        $obj->save();
        DB::commit();

    }
}
