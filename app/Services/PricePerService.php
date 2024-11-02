<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;
use Exception;

class PricePerService
{
    public static function calculatePricePerService($cost_price, $qtd_service)
    {
        return $cost_price / $qtd_service;
    }
}
