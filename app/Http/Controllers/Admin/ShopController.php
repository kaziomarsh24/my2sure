<?php

namespace App\Http\Controllers\Admin;

use App\orders;
use App\shop;
use App\Http\Controllers\Controller;
use App\transactions;
use App\variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
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
            'name' => 'sometimes|nullable',
        ]);

        try {
            if ($validator->fails()) {
                throw new ValidationException("Validation fails.");
            }

            if (!empty($request->name)) {
                $objGames = shop::where('name', 'like', '%' . $request->name . '%')->orderBy('id', 'DESC')->get();
            } else {
                $objGames = shop::all();
            }

            $data = [
                'objGames' => $objGames,
                'pageTitle' => "Products",
            ];

            return view('admin.shop.index')->with($data);
        } catch (ValidationException $e) {
            return back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
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
            $objGames      = shop::all();
            $passData = [
                "pageTitle"     => "Add New Product",
                "objGames"     	=> $objGames,
            ];

            return view('admin.shop.create')->with($passData);

        }catch(\Exception $e)
        {
            report($e);
            return back()->withErrors($e) ->withInput();
        }
    }
    public function edit($getId = null)
    {
        try
        {
            $objData = shop::findOrFail($getId);
            $variants =variant::where('product_id',$getId)->get();



            $passData = [
                "pageTitle" => "Edit ".$objData->name,
                "objData" => $objData,
                'variants' => $variants,
            ];

            return view('admin.shop.edit')->with($passData);
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
            'description' 	=> 'required',
            'logo' 		=> 'required',
            'price' 		=> 'required',
        ];
        $reqFields = ['name','status','description','price' ];
        $validator = \Validator::make($request->all(), $data);

        try
        {
            if($validator->fails())
            {
                throw new ValidationException("Validation fails.");
            }

            $inputData      = $request->all($reqFields);
            $PictureName = md5($inputData['name']);

            if($request->has('logo'))
            {
                $file = $request->file('logo');
                $destinationPath = 'uploads';
                $file->move($destinationPath,$PictureName);
                $inputData['logo']   = $PictureName;
            }

            DB::beginTransaction();
            $obj = new shop($inputData);

            $obj->save();
            $has_variant=0;
            //add product variants
            for($i=0; $i< count($request->label); $i++){

                if( ($request->label[$i] !=null && $request->label[$i] !="") && ($request->stock[$i] != null && $request->stock[$i] != "") ) {
                    $variants = new variant();

                    $variants->product_id = $obj->id;
                    $variants->label = $request->label[$i];
                    $variants->stock = $request->stock[$i];
                    $variants->created_at = date('Y-m-d');
                    $variants->save();
                    $has_variant=1;
                }
            }

            if($has_variant==1){

                $product1= shop::where('id',$obj->id)->first();
                $product1->has_variant=1;
                $product1->save();
            }

            DB::commit();

            return redirect()->route('admin.shop.index');

        }catch(\ValidationException $e)
        {
            DB::rollBack();
            dd($e);
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
            'description' 	=> 'required',
            'price' 		=> 'required',
        ];
        $reqFields = ['name','description','status','price'  ];
        $validator = \Validator::make($request->all(), $data);
        try
        {
            if($validator->fails())
            {
                throw new \ValidationException("Validation fails.");
            }
            $inputData = $request->all($reqFields);

            $objData = shop::findOrFail($id);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();
            $objData->name 			= $inputData['name'];
            $objData->description		= $inputData['description'];
            $objData->price 		= $inputData['price'];
            $PictureName            = md5($inputData['name']);
            if($request->has('logo'))
            {
                $file = $request->file('logo');
                $destinationPath = 'uploads';
                $file->move($destinationPath,$PictureName);
                $objData->logo   = $PictureName;
            }

            //add product variants
            $product_variants=variant::where('product_id',$id)->delete();
            $has_variant=0;
            for ($i = 0; $i < count($request->label); $i++) {

                if ( ($request->label[$i] != null && $request->label[$i] != "") && ($request->stock[$i] != null && $request->stock[$i] != "") ) {

                    $variants = new variant();

                    $variants->product_id = $id;
                    $variants->label = $request->label[$i];
                    $variants->stock = $request->stock[$i];
                    $variants->created_at = date('Y-m-d');
                    $variants->save();
                    $has_variant=1;
                }
            }

            if($has_variant==1){

                $objData->has_variant=1;
            }

            $objData->save();

            DB::commit();
            return redirect()->route('admin.shop.index');

        }catch(\ValidationException $e)
        {
            DB::rollBack();
            dd($e);
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
    public function destroy($getId = null)
    {
        try
        {
            if(!isset($getId))
            {
                throw new \ValidationException("Validation fails.");
            }

            $objData = shop::findOrFail($getId);
            if(empty($objData))
            {
                throw new \Exception("Data Not Found ", 1);
            }
            DB::beginTransaction();

            $objData->delete();

            DB::commit();
            return redirect()->route('admin.shop.index');

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
    public function all_orders(){

        $orders=orders::with(['user','product','variant'])->orderBy('id', 'DESC')->paginate(50);

        $data = [
            'orders' => $orders,
            'pageTitle' => 'Orders',
        ];

        return view('admin.shop.orders')->with($data);

    }
    public function transactions(){


        $transactions=transactions::orderBy('tid', 'DESC')->get();

        $data = [
            'transactions' => $transactions,
            'pageTitle' => 'Transactions',
        ];

        return view('admin.shop.transactions')->with($data);


    }
}
