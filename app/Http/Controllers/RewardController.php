<?php

namespace App\Http\Controllers;

use App\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function pay(Request $request)
    {
        $user      = Auth::user();
        $lotteryId = $request->lottery_id;
        $paymentId = $request->payment_id;

        // Delete winner entry — restores Choose For Me
        Winner::where('user_id', $user->id)->delete();

        return response()->json(['status' => 'success']);
    }
}
