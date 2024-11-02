<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Carbon;

class HomeValueCalculatorService
{
    public static function homeValueCalculator($serviceValue, $userId)
    {
        $settings = Setting::find(1);

        $commission = CommissionCalculatorService::calculateUserCommission($userId, $serviceValue);

        $homeValuePercent = $settings->home_percent;

        return ($serviceValue - $commission) * ($homeValuePercent / 100);
    }

    public static function titheCalculator($commission, $serviceValue, $homeValue)
    {
        $settings = Setting::find(1);
        $titheValuePercent = $settings->tithe;

        $totalValue = $serviceValue - $commission - $homeValue;

        return $totalValue * ($titheValuePercent / 100);
    }
}
