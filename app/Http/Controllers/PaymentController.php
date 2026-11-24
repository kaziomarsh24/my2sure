<?php

namespace App\Http\Controllers;

use App\setting as settings;
use App\transactions;
use App\User;
use App\setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;

use Stripe;

class PaymentController extends Controller
{

    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCEEDED = 'succeeded';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = app()->make("objSetting");
    }
    public function index(Request $request)
    {
        $objUser = [];
        if($request->has("user"))
        {
            $objUser = User::find($request->user);
            if(!empty($objUser))
            {
                if($objUser->expiry_date > date('Y-m-d'))
                {
                    $getStatus = "you already Have a Subscription";
                    $getMessage = "<h3>".$objUser->name."</h3>
		    		 Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                    return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                }
            }
        }else
        {
            $AuthUser = \Auth::user();
            if(!empty($AuthUser))
            {
                $objUser = $AuthUser;
                if($objUser->expiry_date > date('Y-m-d'))
                {
                    $getStatus = "you already Have a Subscription";
                    $getMessage = "<h3>".$objUser->name."</h3>
                     Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                    return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                }
            }
        }
        return redirect()->route('client.payWithCard',['user' => $objUser->id]);

        return view('client.payment.pricing')->with(['objUser'=>$objUser,'settings'=>$this->settings]);
    }

    public function redirectPayment(Request $request)
    {
        $objUser = [];
        $getStatus = $request->get('status');
        $getMessage = $request->get('msg');

        return view('client.payment.redirectPayment')->with(['status'=>$getStatus,'msg'=>$getMessage,'settings'=>$this->settings]);
    }
    public function payWithpaypal()
    {
        $objUser=\Auth::user();
        return view('client.payment.pricingStripe')->with(['objUser'=>$objUser,'settings'=>$this->settings]);
    }

    public function getPaymentStatus(Request $request)
    {


        $payment_id = $request->payment_id;

        if ($request->status == 'true') {

            //update user subscription status
            $expiry_date = Carbon::now()->addMonth()->format('Y-m-d');

            $user=User::where('id',Auth::user()->id)->first();

            $user->isActive=1;
            $user->expiry_date=$expiry_date;
            $user->update();

            //insert into transactions

            $transaction=new transactions();

            $transaction->user_id=$user->id;
            $transaction->order_id='';
            $transaction->tranx_id=$request->payment_id;
            $transaction->payment_amount=$request->amount;
            $transaction->payment_type="Subscription";
            $transaction->payment_status="Success";
            $transaction->save();

            // SEND MAIL TO User
            $getSubject = "Subscription Activate - MY2Sure ";
            $getMessage_user = " Congratulations we've Got Your Subscription Payment Successfully. Your Subscription  Expiry date : " . $expiry_date . "<br />";
            $mailData = [
                "subject" => $getSubject,
                "message" => $getMessage_user,
            ];
            Mail::to(Auth::user()->email)->send(new GlobalMail(Auth::user()->email, $mailData['subject'], $mailData['message']));

            // MAIL TO ADMIN
            $settings = setting::get();
            $admin_email=$settings->firstWhere('name', 'email')->detail;
            $getSubject = "New Subscription";
            $getMessage = " Congratulations you've Got New Subscription Payment Successfully <Br/> User FullName : " . Auth::user()->name . "<br /> User Email : " . Auth::user()->email . "<br />";
            $mailData = [
                "email" => $admin_email,
                "subject" => $getSubject,
                "message" => $getMessage,
            ];

            Mail::to($admin_email)->send(new GlobalMail($mailData['email'], $mailData['subject'], $mailData['message']));

            return redirect()->route('client.redirectPayment', ['status' => "Activate", "msg" => $getMessage_user]);

        }else{

            $getStatus = "Sorry Payment/Session Expired ";
            $getMessage = " Sorry You've taken so long and your session is Expired You need to Try Again. If you need Further Assistance please Contact us for Further Assistance.";
            return redirect()->route('client.redirectPayment', ['status' => $getStatus, "msg" => $getMessage]);
        }

    }

    //STRIPE

    public function indexStripe(Request $request)
    {
        $objUser = [];
        if($request->has("user"))
        {
            $objUser = User::find($request->user);
            if(!empty($objUser))
            {
                if($objUser->expiry_date > date('Y-m-d'))
                {
                    $getStatus = "you already Have a Subscription";
                    $getMessage = "<h3>".$objUser->name."</h3>
                     Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                    return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                }
            }
        }else
        {
            $AuthUser = \Auth::user();
            if(!empty($AuthUser))
            {
                $objUser = $AuthUser;
                if($objUser->expiry_date > date('Y-m-d'))
                {
                    $getStatus = "you already Have a Subscription";
                    $getMessage = "<h3>".$objUser->name."</h3>
                     Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                    return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                }
            }
        }

//        return view('client.payment.pricingStripe')->with(['objUser'=>$objUser,'settings'=>$this->settings]);
    }
    public function stripePost(Request $request)
    {
        $getErrorCodes = [
            'token_already_used'=>'Sorry You cannot use this card for next 1 minutes . please refresh and try again',
            'card_declined'=> 'Sorry Your card was declined . Please try to use Another Card or Try again ',
        ];
        try
        {

            $objUser = [];
            if($request->has("user"))
            {
                $objUser = User::find($request->user);
                if(!empty($objUser))
                {
                    if($objUser->expiry_date > date('Y-m-d'))
                    {
                        $getStatus = "you alreay Have a Subscription";
                        $getMessage = "<h3>".$objUser->name."</h3>
                         Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                        return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                    }
                }
            }else
            {
                $AuthUser = \Auth::user();
                if(!empty($AuthUser))
                {
                    $objUser = $AuthUser;
                    if($objUser->expiry_date > date('Y-m-d'))
                    {
                        $getStatus = "you already Have a Subscription";
                        $getMessage = "<h3>".$objUser->name."</h3>
                         Your Current Subscription <b>". $this->settings->firstWhere('name', 'sub_name')->detail. "</b> Expires on <b>".$objUser->expiry_date." </b><br/> You cannot Purchase Until Your Previous Subscription Expires <br/> After Expire You can Renew it ";
                        return redirect()->route('client.redirectPayment',['status' => $getStatus,"msg"=>$getMessage]);
                    }
                }
            }
//
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $getDetails = $request->get('iName') . " - ". $request->get('iDetails');
            $objStripe = Stripe\Charge::create ([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => $getDetails
            ]);
            $arrPaymentInformation = $userInfoArr = [];
            if($objStripe->status == self::STATUS_SUCCEEDED)
            {
                //UPDATE USER EXPIRY DATE


                $cYear = date("Y");
                $getDayAndMonth = date("m-d",strtotime($this->settings->firstWhere('name', 'sub_renew')->detail));
                $subDate = $cYear."-".$getDayAndMonth;
                $updateDate = date('Y-m-d',strtotime($subDate." +1 years"));
                $updateData = [
                    'isActive'=> '1',
                    'expiry_date'=> $updateDate,
                ];
                //UPDATE USER EXPIRY DATE

                //UPDATE EMAIL DATA
                $getSubject = "Your Payment has been Recieved and Your Account is ready ";
                $getMessage = " Hello <b>".$objUser->name."</b> <br/> Thanks for signing up to ".config('APP_NAME')." <Br/>
                We Have Recieved Your Payment Via Card in the amount of $".$request->get('amount')." and it has been applied to your Account.Please keep this email as a recipt for your records .";
                $arrPaymentInformation = [
                    '<b>Your Payment Details are </b>',
                    'Card : **** **** **** '.$objStripe->payment_method_details->card->last4." - ". $objStripe->payment_method_details->card->network,
                    'Currency : '.$objStripe->currency,
                    'Amount Paid  : $'.($objStripe->amount / 100 ),
                    'Date Paid  : '.date('Y-m-d H:i:s'),
                    'Details  : '.$objStripe->description,
                    'Status  :  COMPLETED',
                    'For Recipt  : <a href="'.$objStripe->receipt_url.'" title="Click To View Recipt" >View Recipt</a>',
                    'Transaction Id  : '.$objStripe->id,
                ];

                //UPDATE USER EMAIL DATA


                $objUser->isActive = 1;
                $objUser->expiry_date = $updateDate;
                $objUser->update();

                //Create Transaction
                // $objTransaction = transactionDetails::create([
                //     'amount'    => ($objStripe->amount / 100 ),
                //     'user_id'   => $objUser->id,
                //     'type'      => 'stripe',
                //     'status'    => 'approved',
                //     'details'   => json_encode($arrPaymentInformation),
                // ]);
            }else if($objStripe->status == self::STATUS_PENDING)
            {
                $getSubject = "Your payment for ".config('APP_NAME')." Subscription  is being processed ";
                $getMessage = " Hello <b>".$objUser->name."</b> <br/>
                    Your payment for ".config('APP_NAME')." Subscription  Via Card in the amount of  $".$request->get('amount')." is being processed .We will Inform you via email with your new Account Details if the Payment is approved or you can contact us any time  ".config('CONTACT_LINK')."<hr/> Once the payment is Approved you will get your Account Details for Login Via Email";
                $arrPaymentInformation = [
                    '<b>Your Payment Details are </b>',
                    'Card : **** **** **** '.$objStripe->payment_method_details->card->last4." - ". $objStripe->payment_method_details->card->network,
                    'Currency : '.$objStripe->currency,
                    'Amount Paid  : $'.($objStripe->amount / 100 ),
                    'Date Paid  : '.date('Y-m-d H:i:s'),
                    'Status  :  IN PROCESSED',
                    'Details  : '.$objStripe->description,
                    'Transaction Id  : '.$objStripe->id,
                ];
                //  $objTransaction = transactionDetails::create([
                //     'amount'    => ($objStripe->amount / 100 ),
                //     'user_id'   => $objUser->id,
                //     'type'      => 'stripe',
                //     'status'    => 'approved',
                //     'details'   => json_encode($arrPaymentInformation),
                // ]);
            }else
            {
                $getSubject = "Your Payment has been Rejected ";
                $getMessage = " Hello <b>".$objUser->name."</b> <br/>
                    We are sorry to inform your that Your Payment Via Card in the amount of $".$request->get('amount')." is been Rejected for some reason .Please Try again if this happened again then contact Your Card Provider.";
            }

            // MAIL AREA
            $getMessage .= " <hr />
                ".implode("<br/>", $arrPaymentInformation)." <br/>
                If you are using Gmail and this message is in your Spam folder, you need to click the 'Not spam' button to enable links.
                <br/>
                If you're unable to click the link above, just copy and paste it into your browser's address bar.
                <br/>
                For easy access to valuable news and information, remember to add us to your email contacts <br/>
                If you need any kind of help please dont hestigate to contact our support ".config('MAIL_FROM_ADDRESS');
            $mailData = [
                "email" => $objUser->email,
                "subject" => $getSubject,
                "message" => $getMessage,
            ];
            $adminMail = "talhachamp7003620@gmail.com";
            Mail::to($adminMail)->send(new GlobalMail($adminMail,$mailData['subject'],$mailData['message']));
            $adminMail = "Okaigbuabolaji@gmail.com";
            Mail::to($adminMail)->send(new GlobalMail($adminMail,$mailData['subject'],$mailData['message']));
            $adminMail = $objUser->email;
            Mail::to($adminMail)->send(new GlobalMail($adminMail,$mailData['subject'],$mailData['message']));
            // MAIL AREA
            Session::flash('success', 'Payment successful! Please check your Mail for login Details');

            return redirect()->route('login')->with('message','Please check your Mail for Login & Payment Details');
        }catch(Stripe\Exception\InvalidRequestException $e)
        {
            $message = $e->getMessage();
            if($e->getStripeCode() == "token_already_used" || $e->getStripeCode() == "card_declined")
            {
                $message = $getErrorCodes[$e->getStripeCode()];
            }else
            {
                $message = $e->getMessage();
            }
            Session::flash('error', $message);
            return redirect()->back() ->withInput($request->input()) ;

        }catch(Stripe\Exception\CardException $e)
        {
            $message = $e->getMessage();
            if($e->getStripeCode() == "token_already_used" || $e->getStripeCode() == "card_declined")
            {
                $message = $getErrorCodes[$e->getStripeCode()];
            }else
            {
                $message = $e->getMessage();
            }
            Session::flash('error', $message);
            return redirect()->back() ->withInput($request->input()) ;

        }catch(\Exception $e)
        {
            $message = $e->getMessage();
            if($e->getCode() == "23000")
            {
                $message = "Sorry you already have Account with this Email Please use another one ";
            }
            // $message = $e->getMessage();
            Session::flash('error', $message);

            return redirect()->back() ->withInput($request->input()) ;
        }
    }
}
