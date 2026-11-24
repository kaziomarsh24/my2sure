<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->objUser = \Auth::user();
            if ($this->objUser->type != "admin") {
                return redirect()->route('client.redirectPayment', [
                    'status' => 'LIMITED ACCESS',
                    'msg'    => '<h3>' . $this->objUser->name . '</h3> You do not have access.'
                ]);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Subscription::with('user')->orderBy('id', 'DESC');

        if (!empty($request->type)) {
            $query->where('type', $request->type);
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->paginate(50);

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'pageTitle'     => 'Subscriptions',
        ]);
    }

    public function create()
    {
        $users = User::where('type', 'user')->orderBy('name')->get();

        return view('admin.subscriptions.create', [
            'users'     => $users,
            'pageTitle' => 'Add Subscription',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'type'       => 'required|in:vip,two_sure,all_games',
            'starts_at'  => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
        ]);

        $existing = Subscription::where('user_id', $request->user_id)
            ->where('type', $request->type)
            ->first();

        if ($existing) {
            $existing->update([
                'status'     => 'active',
                'starts_at'  => $request->starts_at,
                'expires_at' => $request->expires_at,
                'payment_id' => 'manual',
                'amount'     => 0,
            ]);
        } else {
            Subscription::create([
                'user_id'    => $request->user_id,
                'type'       => $request->type,
                'payment_id' => 'manual',
                'amount'     => 0,
                'currency'   => 'USD',
                'status'     => 'active',
                'starts_at'  => $request->starts_at,
                'expires_at' => $request->expires_at,
            ]);
        }

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription added successfully.');
    }

    public function destroy($id)
    {
        Subscription::findOrFail($id)->delete();
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription deleted.');
    }

    public function expire($id)
    {
        Subscription::findOrFail($id)->update([
            'status'     => 'expired',
            'expires_at' => date('Y-m-d'),
        ]);
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription expired.');
    }
}
