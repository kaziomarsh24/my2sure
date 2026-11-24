<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\games;
use App\lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamesController extends Controller
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
            'name' 			=> 'sometimes|nullable',
        ]);

        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }

            if(!empty($request->name))
            {
                $objGames = games::whereStatus('1')
                    ->where('name', 'like', '%'.$request->name.'%') ->orderBy('id', 'DESC')->with(['lottery'])->get();
            }else
            {
                $objGames = games::whereStatus('1')->with(['lottery'])->get();
            }

            $data = [
                'objGames' 		=> $objGames,
                'pageTitle' 	=> "Games",
            ];
            return view('admin.games.index')->with($data);
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
                "pageTitle"     => "Add New Games",
                "objGames"     	=> $objGames,
            ];

            return view('admin.games.create')->with($passData);
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
            $objData = games::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.games.edit')->with($passData);
        }catch(\Exception $e)
        {
            report($e);
            return back()->withErrors($e)
                ->withInput();
        }
    }
    public function store(Request $request)
    {
        $data = [
            'name' 			=> 'required',
            'details' 		=> 'required',
            'status' 		=> 'required',
            'end_date' 		=> 'required',
        ];
        $reqFields = ['name','status','details','end_date' ];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }
            $inputData = $request->all($reqFields);
            $PictureName = md5($inputData['name']);
            if($request->has('logo'))
            {
                $file = $request->file('logo');
                $destinationPath = 'uploads';
                $file->move($destinationPath,$PictureName);
                $inputData['logo']   = $PictureName;
                $inputData['last_end_date']   = $request->end_date;
            }
            DB::beginTransaction();
            $obj = new games($inputData);

            $obj->save();

            DB::commit();

            return redirect()->route('admin.games.index');

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
    public function update($id,Request $request)
    {
        $data = [
            'name' 			=> 'required',
            'details' 		=> 'required',
            'status' 		=> 'required',
            'end_date' 		=> 'required',
        ];
        $reqFields = ['name','details','status','end_date'];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new \ValidationException("Validation fails.");
            }
            $inputData = $request->all($reqFields);

            $objData = games::findOrFail($id);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            $last_end_date=$objData->end_date;
            DB::beginTransaction();
            $objData->name 			= $inputData['name'];
            $objData->details 		= $inputData['details'];
            $objData->status 		= $inputData['status'];
            $objData->end_date 		= $inputData['end_date'];
            $objData->last_end_date = $last_end_date;
            $PictureName            = md5($inputData['name']);
            if($request->has('logo'))
            {
                $file = $request->file('logo');
                $destinationPath = 'uploads';
                $file->move($destinationPath,$PictureName);
                $objData->logo   = $PictureName;
            }
            $objData->save();
            DB::commit();

            return redirect()->route('admin.games.index');

        }catch(\ValidationException $e)
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
    public function destroy($getId)
    {
        try
        {
            if(!isset($getId))
            {
                throw new \ValidationException("Validation fails.");
            }

            $objData = games::findOrFail($getId);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->delete();

            DB::commit();
            return redirect()->route('admin.games.index');

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

    public function save_schedule(Request  $request){

        $game=games::where('id',$request->game_id)->first();

        if($game){

            $game->schedule=$request->schedule;
            $game->save();

            return "true";

        }else{

            return 'false';
        }

    }


}
