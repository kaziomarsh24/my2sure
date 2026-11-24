<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TitleController extends Controller
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
            $obj = DB::table('title')->get();

            $data = [
                'obj'      => $obj,
                'pageTitle'     => "Title & Social Links",
            ];
            return view('admin.title.index')->with($data);
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
            $objData = title::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.title.edit')->with($passData);
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
            'result_section'          => 'required',

        ];

        DB::table('title')
        ->where('id', $request->id) // find your user by their email
        ->update(array('result_section' => $request->result_section)); // update the record in the DB.

        return redirect()->route('admin.title.index');
    }


}
