<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\User;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->settings = app()->make("objSetting");
        $this->middleware(function ($request, $next) {

            $this->objUser = \Auth::user();

            return $next($request);
        });
    }

    public function referralpage($user_id = null){

        if($user_id == null ){

            $user_id=$this->objUser->id;
            $from_ref_code=$this->objUser->ref_code;

        }else{

            $users=User::where('id',$user_id)->first();
            $user_id=$users->id;
            $from_ref_code=$users->ref_code;
        }


        $account=BankAccount::where('user_id',$user_id)->first();
        $users=[];

        if($from_ref_code==""){

            $users=[];

        }else{

            $users=User::where('from_ref_code',$from_ref_code)->get();
        }


        return view('client.home.referral',compact('account','users','from_ref_code'));

    }
    public function saveBankdetails(Request $request){
        //status=1 create new , 0 = update,

        if($request->status==1){

            $bankAccount = BankAccount::create([
                'user_id' => $this->objUser->id,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'status' => $request->status,
            ]);

        }else{

            $bankAccount=  BankAccount::where('user_id', $this->objUser->id)
                ->update([

                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'bank_name' => $request->bank_name,
                ]);
        }

        return redirect(route('client.referralpage'));

    }
}
