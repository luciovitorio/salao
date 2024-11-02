<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Carbon;

class CalculateTotalProductCostService
{
    public static function caculateTotalProductCost(Service $service)
    {
        $totalProductCost = 0;

        foreach ($service->products as $product) {
            $totalProductCost += $product->pivot->cost_price;
        }

        return $totalProductCost;
    }
}
