<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SocialMediaLinkController;
use App\Mail\GlobalMail;
use App\lottery;
use App\setting;
use App\SocialMediaLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->settings = app()->make("objSetting");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $objLotteries = lottery::whereStatus('1')->with(['game'])->get();
        $data = [
            'settings'      => $this->settings,
            'objLotteries'  => $objLotteries,
        ];
        return view('client.home.index')->with($data);
    }



    public function about()
    {
        $data = [
            'settings'      => $this->settings,
        ];
        return view('client.home.about')->with($data);
    }

    public function tos()
    {
        $data = [
            'settings'      => $this->settings,
        ];
        return view('client.home.tos')->with($data);
    }

    public function play()
    {

        $data = [
            'settings'      => $this->settings,
        ];
        return view('client.home.play')->with($data);
    }

    public function contact(Request $request)
    {
//        dd($request->all());
        if($request->has('msg'))
        {
            $msg = $request->get('msg');
        }else
        {
            $msg = "1";
        }
        $social_links= SocialMediaLink::get();
        $data = [
            'msg'            => $msg,
            'settings'      => $this->settings,
            'social_links'=>$social_links,
        ];

        return view('client.home.contact',compact('social_links'))->with($data);
    }
    public function SendContact(Request $request)
    {


        $inputArr = ['name','email','subject','message'];
        $allInputs = $request->all($inputArr);
        $getSubject = "New Contact Query - My2Sure";
        $getMessage = " Name : ".$allInputs['name']."<br />";
        $getMessage .= " Email : ".$allInputs['email']."<br />";
        $getMessage .= " Phone Number : ".$request->phone."<br />";
        $getMessage .= " Subject : ".$allInputs['subject']."<br />";
        $getMessage .= " Message : ".$allInputs['message']."<br />";
        $mailData = [
            "subject" => $getSubject,
            "message" => $getMessage,
        ];
        $adminMail = $this->settings->firstWhere('name', 'email')->detail;
        Mail::to($adminMail)->send(new GlobalMail($allInputs['email'],$mailData['subject'],$mailData['message']));
        return redirect()->route('client.contact')->withErrors(['msg'=>'Your Query is Recieved']);
    }
}
