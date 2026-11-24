<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function detect(Request $request)
    {
        try {
            // Get real IP
            $ip = $request->header('CF-Connecting-IP')
                ?? $request->header('X-Forwarded-For')
                ?? $request->header('X-Real-IP')
                ?? $request->ip();

            // X-Forwarded-For can contain multiple IPs
            if (str_contains($ip, ',')) {
                $ip = trim(explode(',', $ip)[0]);
            }

            // Local dev fallback
            if ($ip === '127.0.0.1' || $ip === '::1') {
                $ip = '8.8.8.8';
            }

            // Get country from IP
            $details     = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
            $countryCode = $details->countryCode ?? 'US';

            // Currency map
            $currencyMap = [
                'GH' => 'GHS', 'NG' => 'NGN', 'KE' => 'KES',
                'ZA' => 'ZAR', 'UG' => 'UGX', 'TZ' => 'TZS',
                'RW' => 'RWF', 'CM' => 'XAF', 'SN' => 'XOF',
                'CI' => 'XOF', 'ZM' => 'ZMW', 'ET' => 'ETB',
                'EG' => 'EGP', 'MA' => 'MAD', 'GB' => 'GBP',
                'DE' => 'EUR', 'FR' => 'EUR', 'IT' => 'EUR',
                'ES' => 'EUR', 'NL' => 'EUR', 'BE' => 'EUR',
                'US' => 'USD', 'CA' => 'CAD', 'AU' => 'AUD',
                'NZ' => 'NZD', 'IN' => 'INR', 'PK' => 'PKR',
                'AE' => 'AED', 'SA' => 'SAR', 'BR' => 'BRL',
                'MX' => 'MXN', 'ML' => 'XOF', 'BF' => 'XOF',
                'BJ' => 'XOF', 'TG' => 'XOF', 'NE' => 'XOF',
            ];

            $currency = $currencyMap[$countryCode] ?? 'USD';

            // Get exchange rate — free, no API key needed
            $rateResponse = file_get_contents("https://open.er-api.com/v6/latest/USD");
            $rateData     = json_decode($rateResponse, true);
            $rate         = $rateData['rates'][$currency] ?? 1;

            return response()->json([
                'country_code' => $countryCode,
                'currency'     => $currency,
                'rate'         => $rate,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'country_code' => 'US',
                'currency'     => 'USD',
                'rate'         => 1,
            ]);
        }
    }
}
