<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GlobalMail;
use App\Providers\RouteServiceProvider;
use App\User;
use App\setting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $free_mode=0;
    public $two_sure_free_mode=0;
    public $all_games_free_mode=0;

    public function __construct()
    {
        global $free_mode;
        global $two_sure_free_mode;
        global $all_games_free_mode;

        $this->middleware('guest');
        $this->settings = setting::get();
        $collection = collect(json_decode($this->settings, true));

        $free_mode = $collection->where('name', 'free_mode')->pluck('detail')->first();
        $two_sure_free_mode = $collection->where('name', 'two_sure_free_mode')->pluck('detail')->first();
        $all_games_free_mode = $collection->where('name', 'all_games_free_mode')->pluck('detail')->first();

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'from_ref_code' => ['required','string'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'from_ref_code' => $data['from_ref_code'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //set referral code
        $objData = User::findOrFail($user->id);

        $objData->ref_code = md5($objData->id);
        $objData->save();

        //______________________

        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        global $free_mode;
        global $two_sure_free_mode;
        global $all_games_free_mode;

        $sub_text="";

        //if site is in paid mode
        if($two_sure_free_mode == 1 && $all_games_free_mode == 1 ){

            $sub_text="For access to the all the  Lottery Forecaster we offer, you just need to purchase the Annual Subscription. You can do this by clicking the link below <br />
            ".route('login')." <br/>";

        }

        // MAIL AREA
        $getSubject = "You're one step away from becoming a member at My2Sure.com";
        $getMessage = " Hello <b>".$user->name."</b> <br/> Thanks for signing up to My2Sure.com <Br/>";

        $getMessage.=$sub_text;

        $getMessage.= " If you are using Gmail and this message is in your Spam folder, you need to click the 'Not spam' button to enable links.
            <br/>
            If you're unable to click the link above, just copy and paste it into your browser's address bar.
            <br/>
            For easy access to valuable news and information, remember to add us to your email contacts";

        $mailData = [
            "email" => $user->email,
            "subject" => $getSubject,
            "message" => $getMessage,
        ];
        $adminMail = $mailData['email'];
        // Mail::to($adminMail)->send(new GlobalMail($mailData['email'],$mailData['subject'],$mailData['message']));
        // MAIL AREA
        return redirect()->route('home');

        return $request->wantsJson()
            ? new Response('', 201)
            : redirect($this->redirectPath());
    }

//    public function showRegistrationForm()
//    {
//        return view('auth.register')->with(['settings'=>$this->settings]);
//    }

    public function showRegistrationForm($from_ref_code = null)
    {
        return view('auth.register', compact('from_ref_code'));
    }


}
