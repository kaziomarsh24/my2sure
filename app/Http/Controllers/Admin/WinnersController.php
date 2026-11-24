<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\forecasterPlay;
use App\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WinnersController extends Controller
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

    public function mark(Request $request)
    {
        $entries = $request->entries ?? [];

        if (empty($entries)) {
            return back()->withErrors(['error' => 'No entries selected.']);
        }

        DB::beginTransaction();
        try {
            foreach ($entries as $playId) {
                $play = forecasterPlay::with('lottery')->find($playId);
                if (!$play) continue;

                // Check if already marked
                $exists = Winner::where('user_id', $play->user_id)
                    ->where('lottery_id', $play->lottery_id)
                    ->exists();

                if (!$exists) {
                    Winner::create([
                        'user_id'    => $play->user_id,
                        'lottery_id' => $play->lottery_id,
                        'marked_at'  => now(),
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', count($entries) . ' winner(s) marked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function index(Request $request)
    {
        $winners = Winner::with(['user', 'lottery'])
            ->orderBy('id', 'DESC')
            ->paginate(50);

        // Get forecaster play data for each winner
        $winnerUserIds = $winners->pluck('user_id')->toArray();
        $winnerLotteryIds = $winners->pluck('lottery_id')->toArray();

        $plays = \App\forecasterPlay::whereIn('user_id', $winnerUserIds)
            ->whereIn('lottery_id', $winnerLotteryIds)
            ->get()
            ->keyBy(function($play) {
                return $play->user_id . '_' . $play->lottery_id;
            });

        return view('admin.winners.index', [
            'winners'   => $winners,
            'plays'     => $plays,
            'pageTitle' => 'Winners',
        ]);
    }

    public function destroy($id)
    {
        Winner::findOrFail($id)->delete();
        return back()->with('success', 'Winner entry deleted.');
    }
}
