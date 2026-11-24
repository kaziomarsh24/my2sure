<?php


namespace App\Http\Controllers;

use App\Subscription;
use App\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->settings = app()->make("objSetting");
    }

    // ── Gate check + redirect to Flutterwave ──────────────────

    public function vipGate()
    {
        $user = Auth::user();

        // Check if VIP mode is ON
        $vipMode = $this->settings->firstWhere('name', 'vip_mode')->detail ?? '0';

        if ($vipMode == '0') {
            // Free — let them in
            return redirect()->route('client.vip');
        }

        // Check active subscription
        if (Subscription::isActive($user->id, 'vip')) {
            return redirect()->route('client.vip');
        }

        // No active subscription — show the tiered landing page
        return redirect()->route('client.vip.landing');
    }

    // ── VIP landing page (description + video + 4 tiers) ───────

    public function vipLanding()
    {
        $user = Auth::user();

        $vipMode = $this->settings->firstWhere('name', 'vip_mode')?->detail ?? '0';

        // Free mode — straight into the room
        if ($vipMode == '0') {
            return redirect()->route('client.vip');
        }

        // Already an active subscriber — straight into the room
        if (Subscription::isActive($user->id, 'vip')) {
            return redirect()->route('client.vip');
        }

        // Otherwise show the landing page with the four tiers
        $videoUrl    = $this->settings->firstWhere('name', 'vip_video_url')?->detail ?? '';
        $description = $this->settings->firstWhere('name', 'vip_description')?->detail ?? '';

        $tiers = [
            'day'   => ['label' => '1 Day',   'price' => $this->settings->firstWhere('name', 'vip_price_day')?->detail   ?? '1'],
            'week'  => ['label' => '1 Week',  'price' => $this->settings->firstWhere('name', 'vip_price_week')?->detail  ?? '5'],
            'month' => ['label' => '1 Month', 'price' => $this->settings->firstWhere('name', 'vip_price_month')?->detail ?? '15'],
            'year'  => ['label' => '1 Year',  'price' => $this->settings->firstWhere('name', 'vip_price_year')?->detail  ?? '100'],
        ];

        return view('client.vip_landing', [
            'embedUrl'    => $this->youtubeEmbed($videoUrl),
            'description' => $description,
            'tiers'       => $tiers,
            'user'        => $user,
            'settings'    => $this->settings,
        ]);
    }

    // ── VIP tier selected → go to payment ─────────────────────

    public function vipSubscribe($duration)
    {
        $user = Auth::user();

        // Whitelist of tiers: price-setting key + duration in days + fallback price
        $map = [
            'day'   => ['key' => 'vip_price_day',   'days' => 1,   'default' => '1'],
            'week'  => ['key' => 'vip_price_week',  'days' => 7,   'default' => '5'],
            'month' => ['key' => 'vip_price_month', 'days' => 30,  'default' => '15'],
            'year'  => ['key' => 'vip_price_year',  'days' => 365, 'default' => '100'],
        ];

        if (!isset($map[$duration])) {
            abort(404);
        }

        $tier   = $map[$duration];
        $price  = $this->settings->firstWhere('name', $tier['key'])?->detail ?? $tier['default'];
        $pubKey = config('services.flutterwave.public_key');

        return view('client.subscription.pay', [
            'type'     => 'vip',
            'price'    => $price,
            'duration' => $tier['days'], // days — flows through to handleSuccess()
            'pubKey'   => $pubKey,
            'user'     => $user,
        ]);
    }

    public function twoSureGate()
    {
        $user = Auth::user();

        $mode = $this->settings->firstWhere('name', 'two_sure_mode')->detail ?? '0';

        if ($mode == '0') {
            return redirect()->route('client.giveaway');
        }

        if (Subscription::isActive($user->id, 'two_sure')) {
            return redirect()->route('client.giveaway');
        }

        return $this->initiatePayment('two_sure');
    }

    public function allGamesGate(Request $request)
    {
        $user = Auth::user();

        // Where to send the user once they have access. When the gate is reached
        // from a specific game's "Choose For Me" button, return them to that game.
        $gameId = $request->query('game');
        $intended = $gameId
            ? route('client.games.show', ['game' => $gameId])
            : route('client.games.index');

        $mode = $this->settings->firstWhere('name', 'all_games_mode')->detail ?? '0';

        if ($mode == '0') {
            return redirect($intended);
        }

        if (Subscription::isActive($user->id, 'all_games')) {
            return redirect($intended);
        }

        return $this->initiatePayment('all_games', $intended);
    }

    // ── Initiate Payment ──────────────────────────────────────

    private function initiatePayment($type, $redirect = null)
    {
        $priceKey = $type . '_sub_price';
        $durationKey = $type . '_sub_duration';

        $price = $this->settings->firstWhere('name', $priceKey)->detail ?? '10';
        $duration = $this->settings->firstWhere('name', $durationKey)->detail ?? '30';
        $pubKey = config('services.flutterwave.public_key');
        $user = Auth::user();

        return view('client.subscription.pay', [
            'type' => $type,
            'price' => $price,
            'duration' => $duration,
            'pubKey' => $pubKey,
            'user' => $user,
            'redirect' => $redirect,
        ]);
    }

    // ── Handle successful payment callback ────────────────────

    public function handleSuccess(Request $request)
    {
        $type = $request->type;
        $paymentId = $request->payment_id;
        $amount = $request->amount;
        $currency = $request->currency ?? 'USD';
        $user = Auth::user();

        // Prefer the duration passed from the payment page (per-tier for VIP);
        // fall back to the type's configured duration setting (2Sure / All Games / legacy VIP).
        if ($request->filled('duration')) {
            $duration = (int) $request->duration;
        } else {
            $durationKey = $type . '_sub_duration';
            $duration = (int) ($this->settings->firstWhere('name', $durationKey)?->detail ?? 30);
        }

        if ($duration <= 0) {
            $duration = 30;
        }

        $startsAt = date('Y-m-d');
        $expiresAt = date('Y-m-d', strtotime("+{$duration} days"));

        // Check if subscription already exists
        $existing = Subscription::where('user_id', $user->id)
            ->where('type', $type)
            ->first();

        if ($existing) {
            // Reactivate and extend
            $existing->update([
                'payment_id' => $paymentId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'active',
                'starts_at' => $startsAt,
                'expires_at' => $expiresAt,
            ]);
        } else {
            // Create new
            Subscription::create([
                'user_id' => $user->id,
                'type' => $type,
                'payment_id' => $paymentId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'active',
                'starts_at' => $startsAt,
                'expires_at' => $expiresAt,
            ]);
        }

        // Prefer an explicit (local) redirect passed from the payment page —
        // e.g. back to the specific game's "Choose For Me" page.
        $redirect = $request->input('redirect');
        if (!empty($redirect) && str_starts_with($redirect, url('/'))) {
            return response()->json(['redirect' => $redirect]);
        }

        // Otherwise fall back to the section's default landing page.
        $routes = [
            'vip' => 'client.vip',
            'two_sure' => 'client.giveaway',
            'all_games' => 'client.games.index',
        ];

        return response()->json(['redirect' => route($routes[$type])]);
    }

    // ── Helpers ───────────────────────────────────────────────

    private function youtubeEmbed($url)
    {
        if (empty($url)) {
            return '';
        }

        $id = '';
        if (preg_match('~youtu\.be/([^?&/]+)~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~[?&]v=([^?&]+)~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~youtube\.com/embed/([^?&/]+)~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~youtube\.com/shorts/([^?&/]+)~', $url, $m)) {
            $id = $m[1];
        }

        return $id ? 'https://www.youtube.com/embed/' . $id : '';
    }
}