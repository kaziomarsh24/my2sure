<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\plan_flags;
use App\plans;
use App\source_plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlansController extends Controller
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
            $obj = plans::get();
            $source_plans = source_plan::get();

            $data = [
                'obj'      => $obj,
                'source_plans' =>$source_plans,
                'pageTitle'     => "All Plans",
            ];

            return view('admin.plans.index')->with($data);
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
            $obj      = plans::whereStatus('1')->get();
            $passData = [
                "pageTitle"     => "Add New Plans",
                "obj"           => $obj,
            ];

            return view('admin.plans.create')->with($passData);
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
            $objData = plans::findOrFail($getId);
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.plans.edit')->with($passData);
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
            'name'          => 'required',
            'sets'          => 'required',
            'numbers'       => 'required',
            'status'        => 'required',
        ];
        $reqFields = ['name','sets','numbers','status' ];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            $number = str_replace("-", ",", $request->numbers);
            $number = str_replace(" ", "", $number);
            $arr = explode(",", $number);
            if($request->sets != count($arr))
            {
                echo "Theres ".$request->sets." Sets but numbers found is ".count($arr).". Please go back and correct that ";die();
            }
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }
            $inputData      = $request->all($reqFields);
            $inputData['numbers'] = $number;
            DB::beginTransaction();
            $obj = new plans($inputData);

            $obj->save();

            DB::commit();

            return redirect()->route('admin.plans.index');

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
            'name'          => 'required',
            'sets'          => 'required',
            'numbers'       => 'required',
            'status'        => 'required',
        ];
        $reqFields = ['name','sets','numbers','status'  ];
        $validator = \Validator::make($request->all(), $data);
        try
        {

            $number = str_replace("-", ",", $request->numbers);

            $number = str_replace(" ", "", $number);
            $arr = explode(",", $number);

            if($request->sets != count($arr))
            {
                echo "Theres ".$request->sets." Sets but numbers found is ".count($arr).". Please go back and correct that ";die();
            }
            if($validator->fails())
            {
                throw new \ValidationException("Validation fails.");
            }
            $inputData = $request->all($reqFields);

            $objData = plans::findOrFail($id);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();
            $objData->name          = $inputData['name'];
            $objData->sets          = $inputData['sets'];
            $objData->status        = $inputData['status'];
            $objData->numbers       = $number;

            $objData->save();
            DB::commit();
            return redirect()->route('admin.plans.index');

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

            $objData = plans::findOrFail($getId);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->delete();

            DB::commit();
            return redirect()->route('admin.plans.index');

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
    //update  plans
    public function updates(Request $request)
    {

        $source_plan=  new source_plan();
        $source_plan->truncate();

        for ($i=0;$i<$request->count;$i++){

            $plan = new source_plan();
            $plan->number = $request->input('plan'.$i);
            $plan->save();

        }


        //get all plans
        $plans = source_plan::all();
        $plans_array = array();

        foreach ($plans as $p) {
            $plans_array[] =  explode(',', $p['number']);
        }

        $ppp = $plan->createPlans($plans_array);

        $new_plan=  new plans();
        $new_plan->truncate();

        foreach ($ppp as $pp){

            $new_plan=  new plans();
            $new_plan->name=$pp->letter;
            $new_plan->sets=$pp->type;
            $new_plan->numbers=implode(',', $pp->values);
            $new_plan->status=1;
            $new_plan->save();
        }

        return redirect()->route('admin.plans.index');


    }//updates


}
