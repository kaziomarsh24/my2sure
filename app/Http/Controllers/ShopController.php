<?php

namespace App\Http\Controllers;

use App\orders;
use App\shop;
use App\transactions;
use App\variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Stripe\Order;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->settings = app()->make("objSetting");

        $this->middleware(function ($request, $next) {
            $this->objUser = \Auth::user();
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
                $objGames = Cache::remember('shop_products', 600, function () {
                    return shop::select('id', 'name', 'price', 'logo')->get();
                });
            }

            $data = [
                'objGames' => $objGames,
                'pageTitle' => "Products",
            ];

            return view('client.home.shop')->with($data);
        } catch (ValidationException $e) {
            return back()->withErrors($validator)->withInput();
        } catch (\Exception $e) {
            report($e);
            return abort(500, "Something Went Wrong. Please Try Again.");
        }
    }
    public function product_details($id){

        $product = shop::findOrFail($id);
        $variants = variant::where('product_id',$id)->get();

        $data = [
            'product' => $product,
            'pageTitle' => $product->name,
            'variants' => $variants,
        ];

        // Now you can use the $product variable to pass product details to your view
        return view('client.home.product_details')->with($data);

    }

    public function place_order(Request $request){
//        dd($request->all());
        $variant = variant::where('id', $request->variant)->first();

        if($request->variant && $variant == null) {
            return response()->json(['status' => 'not_found']);
        }

        if($variant && $variant->stock < $request->product_quantity) {
            return response()->json(['status' => 'less_stock']);
        }

        $order = new orders();
        $order->user_id = $this->objUser->id;
        $order->product_id = $request->product_id;
        $order->quantity = $request->product_quantity;
        $order->total_amount = $request->total_amount;
        $order->payment_id = $request->payment_id;
        $order->variant_id = $request->variant;
        $order->address = $request->address;
        $order->save();


        $transaction = new transactions();
        $transaction->user_id = $this->objUser->id;
        $transaction->order_id = $order->id;
        $transaction->tranx_id = $request->payment_id;
        $transaction->payment_amount = $request->total_amount;
        $transaction->payment_type = "Purchase";
        $transaction->payment_status = "Success";
        $transaction->save();

        if($variant) {
            $variant->stock -= $request->product_quantity;
            $variant->sold += $request->product_quantity;
            $variant->update();
        }

        return response()->json(['status' => 'true']);


    }
    public function my_orders(){

        $orders=orders::where('user_id',$this->objUser->id)->get();

        $data = [
            'orders' => $orders,
            'pageTitle' => 'Orders',
        ];

        return view('client.home.orders')->with($data);

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

}
