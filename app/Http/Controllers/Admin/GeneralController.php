<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\setting As settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GeneralController extends Controller
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

        $this->arrSetting = [
            'site_title'    => 'Site Name',
            'site_details'  => 'Site Details',
            'logo'          => 'Site Logo',
            'meta_keywords' => 'SEO Keywords',
            'meta_details'  => 'SEO Details',
            'email'  => 'Email',
            'phone'  => 'Phone',
            'free_mode'  => 'Free Mode',
            'two_sure_free_mode'  => 'Two Sure Competition Page',
            'all_games_free_mode'  => 'All Games Page',
            'sub_name'  => 'Subscription Name',
            'sub_details'  => 'Subscription Details',
            'sub_price'  => 'Subscription Price',
            'sub_renew'  => 'Subscription Renew Date',
            'vip_button_label'      => 'VIP BUTTON LABEL',
            'vip_button_link'       => 'VIP BUTTON LINK',
            'shop_button_label'     => 'Shop Button Label',
            'shop_button_link'      => 'Shop Button Link',
            'music_button_label'    => 'Music Button Label',
            'music_button_link'     => 'Music Button Link',
            'results_button_label'  => 'Winning Results Button Label',
            'results_button_link'   => 'Winning Results Button Link',
            'about_us_content' => 'About Us Content',
            'giveaway_time_restriction' => '2Sure Time Restriction (6am-7pm)',
            'vip_mode'             => 'VIP Room Access',
            'vip_sub_price'        => 'VIP Subscription Price',
            'vip_sub_duration'     => 'VIP Subscription Duration (days)',
            'two_sure_mode'        => '2Sure Competition Access',
            'two_sure_sub_price'   => '2Sure Subscription Price',
            'two_sure_sub_duration'=> '2Sure Subscription Duration (days)',
            'all_games_mode'       => 'All Games Access',
            'all_games_sub_price'  => 'All Games Subscription Price',
            'all_games_sub_duration'=> 'All Games Subscription Duration (days)',
            'reward_amount' => 'Reward Amount',
            // VIP Landing Page
            'vip_video_url'   => 'VIP YouTube Video URL',
            'vip_description' => 'VIP Description',
            'vip_price_day'   => 'VIP Price - 1 Day',
            'vip_price_week'  => 'VIP Price - 1 Week',
            'vip_price_month' => 'VIP Price - 1 Month',
            'vip_price_year'  => 'VIP Price - 1 Year',
        ];

    }

    public function index(Request $request)
    {
    	try
        {
            $obj = settings::get();
	    	$data = [
                'objData'        => $obj,
	    		'arrSetting'     => $this->arrSetting ,
	    		'pageTitle' 	 => "General Settings",
	    	];
	        return view('admin.general.index')->with($data);
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
            echo "No General Method Til yet ";die();
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
            $objGames = settings::whereName($getId)->first();
            $passData = [
                "pageTitle" => "Edit General Settings" ,
                "objGames" => $objGames,
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

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
   public function update($id ,Request $request)
    {
        $data = [
            'site_title'          => 'required',
            'site_details'        => 'required',
            'meta_keywords'       => 'required',
            'meta_details'        => 'required',
            'email'               => 'required',
            'phone'               => 'required',
            'sub_name'            => 'required',
            'sub_renew'           => 'required',
            'sub_price'           => 'required',
            'sub_details'         => 'required',
            'free_mode'           => 'required',
            'all_games_free_mode' => 'required',
            'two_sure_free_mode'  => 'required',
            // Added validation for new fields
            'vip_button_label'      => 'sometimes|nullable',
            'vip_button_link'       => 'sometimes|nullable',
            'shop_button_label'     => 'sometimes|nullable',
            'shop_button_link'      => 'sometimes|nullable',
            'music_button_label'    => 'sometimes|nullable',
            'music_button_link'     => 'sometimes|nullable',
            'results_button_label'  => 'sometimes|nullable',
            'results_button_link'   => 'sometimes|nullable',
            'about_us_content' => 'sometimes|nullable',
            'giveaway_time_restriction' => 'sometimes|nullable',
            'vip_mode'              => 'sometimes|nullable',
            'vip_sub_price'         => 'sometimes|nullable',
            'vip_sub_duration'      => 'sometimes|nullable',
            'two_sure_mode'         => 'sometimes|nullable',
            'two_sure_sub_price'    => 'sometimes|nullable',
            'two_sure_sub_duration' => 'sometimes|nullable',
            'all_games_mode'        => 'sometimes|nullable',
            'all_games_sub_price'   => 'sometimes|nullable',
            'all_games_sub_duration'=> 'sometimes|nullable',
            'reward_amount' => 'sometimes|nullable',
            // VIP Landing Page
            'vip_video_url'   => 'sometimes|nullable',
            'vip_description' => 'sometimes|nullable',
            'vip_price_day'   => 'sometimes|nullable',
            'vip_price_week'  => 'sometimes|nullable',
            'vip_price_month' => 'sometimes|nullable',
            'vip_price_year'  => 'sometimes|nullable',

        ];

        // Added new fields to the allowed request fields array
        $reqFields = [
            'site_title','site_details' ,'meta_keywords','meta_details','email','phone',
            'sub_name','sub_renew','sub_price','sub_details','free_mode',
            'all_games_free_mode','two_sure_free_mode',
            'vip_button_label', 'vip_button_link',
            'shop_button_label', 'shop_button_link',
            'music_button_label', 'music_button_link',
            'results_button_label', 'results_button_link','about_us_content','giveaway_time_restriction',
            'vip_mode', 'vip_sub_price', 'vip_sub_duration',
            'two_sure_mode', 'two_sure_sub_price', 'two_sure_sub_duration',
            'all_games_mode', 'all_games_sub_price', 'all_games_sub_duration','reward_amount',
            // VIP Landing Page
            'vip_video_url',
            'vip_price_day', 'vip_price_week', 'vip_price_month', 'vip_price_year',
        ];

        $validator = \Validator::make($request->all(), $data);

        try
        {
            if($validator->fails())
            {
                // It is better to use the validator errors for debugging
                return back()->withErrors($validator)->withInput();
            }

            $inputData = $request->only($reqFields); // Changed all() to only() for safety

            DB::beginTransaction();

            settings::where('name','site_title')->update(['detail'=> $inputData['site_title']]);
            settings::where('name','site_details')->update(['detail'=> $inputData['site_details']]);
            settings::where('name','meta_keywords')->update(['detail'=> $inputData['meta_keywords']]);
            settings::where('name','meta_details')->update(['detail'=> $inputData['meta_details']]);
            settings::where('name','phone')->update(['detail'=> $inputData['phone']]);
            settings::where('name','email')->update(['detail'=> $inputData['email']]);
            settings::where('name','free_mode')->update(['detail'=> $inputData['free_mode']]);
            settings::where('name','all_games_free_mode')->update(['detail'=> $inputData['all_games_free_mode']]);
            settings::where('name','two_sure_free_mode')->update(['detail'=> $inputData['two_sure_free_mode']]);
            settings::where('name','sub_name')->update(['detail'=> $inputData['sub_name']]);
            settings::where('name','sub_renew')->update(['detail'=> $inputData['sub_renew']]);
            settings::where('name','sub_price')->update(['detail'=> $inputData['sub_price']]);
            settings::where('name','sub_details')->update(['detail'=> $inputData['sub_details']]);

            // These will now work because they are in $inputData
            settings::where('name','shop_button_label')->update(['detail'=> $inputData['shop_button_label'] ?? '']);
            settings::where('name','shop_button_link')->update(['detail'=> $inputData['shop_button_link'] ?? '']);
            settings::where('name','music_button_label')->update(['detail'=> $inputData['music_button_label'] ?? '']);
            settings::where('name','music_button_link')->update(['detail'=> $inputData['music_button_link'] ?? '']);
            settings::where('name','results_button_label')->update(['detail'=> $inputData['results_button_label'] ?? '']);
            settings::where('name','results_button_link')->update(['detail'=> $inputData['results_button_link'] ?? '']);
            settings::updateOrInsert(
                ['name' => 'about_us_content'],
                ['detail' => $request->input('about_us_content', '')]
            );
            settings::updateOrInsert(
                ['name' => 'giveaway_time_restriction'],
                ['detail' => $inputData['giveaway_time_restriction'] ?? '0']
            );
            settings::updateOrInsert(['name' => 'vip_mode'],              ['detail' => $inputData['vip_mode'] ?? '0']);
            settings::updateOrInsert(['name' => 'vip_sub_price'],         ['detail' => $inputData['vip_sub_price'] ?? '10']);
            settings::updateOrInsert(['name' => 'vip_sub_duration'],      ['detail' => $inputData['vip_sub_duration'] ?? '30']);
            settings::updateOrInsert(['name' => 'two_sure_mode'],         ['detail' => $inputData['two_sure_mode'] ?? '0']);
            settings::updateOrInsert(['name' => 'two_sure_sub_price'],    ['detail' => $inputData['two_sure_sub_price'] ?? '5']);
            settings::updateOrInsert(['name' => 'two_sure_sub_duration'], ['detail' => $inputData['two_sure_sub_duration'] ?? '30']);
            settings::updateOrInsert(['name' => 'all_games_mode'],        ['detail' => $inputData['all_games_mode'] ?? '0']);
            settings::updateOrInsert(['name' => 'all_games_sub_price'],   ['detail' => $inputData['all_games_sub_price'] ?? '5']);
            settings::updateOrInsert(['name' => 'all_games_sub_duration'],['detail' => $inputData['all_games_sub_duration'] ?? '30']);
            settings::updateOrInsert(['name' => 'reward_amount'], ['detail' => $inputData['reward_amount'] ?? '10']);

            // ── VIP Landing Page settings ──────────────────────────
            settings::updateOrInsert(['name' => 'vip_video_url'],   ['detail' => $inputData['vip_video_url'] ?? '']);
            settings::updateOrInsert(['name' => 'vip_description'],  ['detail' => $request->input('vip_description', '')]);
            settings::updateOrInsert(['name' => 'vip_price_day'],    ['detail' => $inputData['vip_price_day'] ?? '1']);
            settings::updateOrInsert(['name' => 'vip_price_week'],   ['detail' => $inputData['vip_price_week'] ?? '5']);
            settings::updateOrInsert(['name' => 'vip_price_month'],  ['detail' => $inputData['vip_price_month'] ?? '15']);
            settings::updateOrInsert(['name' => 'vip_price_year'],   ['detail' => $inputData['vip_price_year'] ?? '100']);

            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $destinationPath = 'assets/images';
                $file->move($destinationPath,'logo.png');
            }

            DB::commit();
            return redirect()->route('admin.general.index');

        } catch(\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($getId)
    {

    }


}