<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\plans;
use App\source_plan;
use Illuminate\Http\Request;

class source_plan_conroller extends Controller
{
    function index()
    {
        return view('admin.plans.source');

    }

    function add(Request $request)
    {

        $plan = new source_plan();

        $plan->number = $request->numbers;
        $plan->save();

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

    }

    function delete($id){
        $plan_delete=source_plan::where('id',$id)->delete();
        $plan= new source_plan();

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
    }
}
