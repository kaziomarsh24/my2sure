<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialMediaLink;
use App\title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialMediaLinkController extends Controller
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
    public function edit($getId)
    {
        try
        {
            $objData = SocialMediaLink::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.socialMediaLinks.edit')->with($passData);
        }catch(\Exception $e)
        {
            report($e);
            return back()->withErrors($e)
                ->withInput();
        }
    }
    public function update(Request $request)
    {

        $link =SocialMediaLink::where('id',$request->id)->first();
        $link->youtube = $request->input('youtube');
        $link->instagram = $request->input('instagram');
        $link->twitter = $request->input('twitter');
        $link->google = $request->input('google');
        $link->facebook = $request->input('facebook');
        $link->linkedin = $request->input('linkedin');
        $link->tiktok = $request->input('tiktok');
        $link->youtube_video = $request->input('youtube_video');
        $link->notification = $request->input('notification');
        // Update other social media links as needed
        $link->update();

        return redirect()->route('admin.socialMediaLinksedit', ['id' => 1]);
    }

}
