<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\slider;
use App\lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
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

        $objsliders = slider::get();

        $data = [
            'objsliders'        => $objsliders,
            'pageTitle'     => "Sliders",
        ];

        return view('admin.slider.index')->with($data);
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
        $passData = [
            "pageTitle"     => "Add New Games",
        ];

        return view('admin.slider.create')->with($passData);
    }

    public function edit($getId)
    {
        try
        {
            $objData = Slider::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ",
                "objData" => $objData,
            ];
            return view('admin.slider.edit')->with($passData);
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

        $reqFields = ['image' ];
        $inputData      = $request->all($reqFields);
        $PictureName = rand(10,100);
        if($request->has('image'))
        {
            $file = $request->file('image');
            $destinationPath = 'uploads';
            $file->move($destinationPath,$PictureName);
            $inputData['image']   = $PictureName;
        }
        DB::beginTransaction();

        $obj = new slider();
        $obj->image=$PictureName;
        $obj->link=$request->link;
        $obj->save();

        DB::commit();

        return redirect()->route('admin.slider.index');

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $reqFields = ['image'];
        $inputData = $request->all($reqFields);

        $objData = slider::findOrFail($request->id);
        if(empty($objData))
        {
            throw new \Exception("Data Not Found ", 1);
        }
        DB::beginTransaction();
        $PictureName            = rand(10,100);
        if($request->has('image'))
        {
            $file = $request->file('image');
            $destinationPath = 'uploads';
            $file->move($destinationPath,$PictureName);
            $objData->image   = $PictureName;
        }

        $objData->link=$request->link;
        $objData->save();
        DB::commit();
        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        $objData = slider::findOrFail($request->id);
        if(empty($objData))
        {
            throw new \Exception("Data Not Found ", 1);
        }
        DB::beginTransaction();

        $objData->delete();

        DB::commit();
        return redirect()->route('admin.slider.index');
    }


}
