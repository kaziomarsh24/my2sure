<?php

namespace App\Http\Controllers\Admin;

use App\forecasterPlay;
use App\Http\Controllers\Controller;
use App\Mail\GlobalMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
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
            'name'  => 'sometimes|nullable',
            'email' => 'sometimes|nullable',
        ]);

        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }

            $query = User::with(['forecaster'])->orderBy('id', 'DESC');

            if(!empty($request->name)) {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            if(!empty($request->email)) {
                $query->where('email', 'like', '%'.$request->email.'%');
            }

            $obj = $query->paginate(request('per_page', 50));

            $data = [
                'obj'       => $obj,
                'pageTitle' => "Users",
            ];

            return view('admin.users.index')->with($data);
        }
        catch(ValidationException $e)
        {
            return back()->withErrors($validator)->withInput();
        }
        catch(\Exception $e)
        {
            report($e);
            return abort(500, "Something Went Wrong. Please Try Again.");
        }
    }
    public function search(Request $request)
    {
        $q = $request->get('q');

        $users = User::where('email', 'like', '%' . $q . '%')
            ->orWhere('name', 'like', '%' . $q . '%')
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    public function prediction()
    {
        return '';
        try
        {
//            if($validator->fails())
//            {
//                throw new ValidationException("Validation fails.");
//            }

//            if(!empty($request->name))
//            {
//                $obj = User::where('name', 'like', '%'.$request->name.'%')->with(['forecaster']) ->orderBy('id', 'DESC')->get();
//
//            }else
//            {

            $obj = User::with(['forecaster'])->get();
//            }

            $data = [
                'obj' 		=> $obj,
                'pageTitle' 	=> "Predictions for the game",
            ];
            return view('admin.users.prediction')->with($data);
        }
        catch(ValidationException $e)
        {
//            return back()->withErrors($validator)
//                ->withInput();
        }
        catch(\Exception $e)
        {
            report($e);
            return abort(500, "Something Went Wrong. Please Try Again.");
        }
    }

    public function show(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'sometimes|nullable',
            'date' => 'sometimes|nullable|date',
        ]);

        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }

            if (!empty($request->name)) {

                $forecasterIds = forecasterPlay::whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                })->pluck('id');

                $query = forecasterPlay::with(['user', 'lottery'])
                    ->whereIn('id', $forecasterIds)
                    ->orderBy('id', 'DESC');

                if (!empty($request->date)) {
                    $query->whereDate('created_at', $request->date);
                }

                $obj = $query->paginate(request('per_page', 50));

            } else {

                $query = forecasterPlay::with(['user', 'lottery'])
                    ->orderBy('id', 'DESC');

                if (!empty($request->date)) {
                    $query->whereDate('created_at', $request->date);
                }

                $obj = $query->paginate(request('per_page', 50));
            }

            $data = [
                'obj'       => $obj,
                'pageTitle' => "Predictions for the game",
            ];

            return view('admin.users.prediction')->with($data);

        }
        catch(ValidationException $e)
        {
            return back()->withErrors($validator)->withInput();
        }
        catch(\Exception $e)
        {
            report($e);
            return abort(500, "Something Went Wrong. Please Try Again.");
        }
    }
//    public function show($id)
//    {
//        try
//        {
//            echo "No Show Method Til yet ";die();
//        }catch(\Exception $e)
//        {
//            dd($e);
//            report($e);
//            return back()->withErrors($e) ->withInput();
//        }
//    }

    public function create()
    {
        try
        {
            $obj      = User::get();
            $passData = [
                "pageTitle"     => "Add New User",
                "obj"     	=> $obj,
            ];

            return view('admin.users.create')->with($passData);
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
            $objData = User::with(['forecaster','forecaster.lottery','forecaster.lottery.game'])->findOrFail($getId);
            // dd($objData->toArray());
            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
            ];
            return view('admin.users.edit')->with($passData);
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

        $data = [
            'name' 			=> 'required',
            'email' 		=> 'required',
            'password' 		=> 'required',
            'type'          => 'required',
            'expiry_date'   => 'required',
            'isActive' 		=> 'required',
        ];
        $reqFields = ['name', 'email', 'password','type','expiry_date','isActive'];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }
            $inputData      = $request->all($reqFields);

            DB::beginTransaction();
            $obj = new User($inputData);

            $obj->save();

            DB::commit();

            return redirect()->route('admin.users.index');

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



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update($id,Request $request)
    {

        $data = [
            'name'          => 'required',
            'email'         => 'required',
            'password'      => 'sometimes',
            'type'          => 'required',
            'expiry_date'   => 'required',
            'isActive'      => 'required',
            'trial_used'    => 'sometimes',
        ];
        $reqFields = ['name', 'email', 'password','type','expiry_date','isActive'];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new \ValidationException("Validation fails.");
            }
            $inputData = $request->all($reqFields);

            $objData = User::findOrFail($id);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();
            $objData->name 			= $inputData['name'];
            $objData->email 		= $inputData['email'];


            if($request->get('password') != null)
            {
                $objData->password      = Hash::make($inputData['password']);
            }
            $objData->type          = $inputData['type'];
            $objData->expiry_date   = $inputData['expiry_date'];
            $objData->isActive 		= $inputData['isActive'];

            if($request->has('extend_trial'))
            {
                if($request->extend_trial == '1')
                {
                    $objData->expiry_date       = date('Y-m-d',strtotime("+1 Day"));
                    $objData->trial_used        = 1;
                    $objData->trial_used_date   = date('Y-m-d');
                }else
                {
                    $objData->trial_used        = 0;
                }
            }

            $objData->save();
            DB::commit();
            return redirect()->route('admin.users.index');

        }catch(\ValidationException $e)
        {
            dd($e);
            DB::rollBack();
            report($e);
            return back()->withErrors($e)
                ->withInput();
        }catch(\Exception $e)
        {
            dd($e);
            DB::rollBack();
            report($e);
            return back()->withErrors($e)
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($getId)
    {
        try
        {
            if(!isset($getId))
            {
                throw new \ValidationException("Validation fails.");
            }

            $objData = User::findOrFail($getId);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->delete();

            DB::commit();
            return redirect()->route('admin.users.index');

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
    public function SendBulkEmail(Request $request){


        try
        {
            // MAIL AREA
            $getSubject = $request->subject;
            $getMessage = $request->email_text;

            $users=User::where('type','user')->get();
//            $users=User::where('id','4314')->get();


            foreach ($users as $user) {

                Mail::to($user->email)->send(new GlobalMail($user->email, $getSubject, $getMessage));
            }

            return redirect(route('admin.general.index'));
        }catch(\Exception $e)
        {
            report($e);
            return back()->withErrors($e)
                ->withInput();
        }
    }

}
