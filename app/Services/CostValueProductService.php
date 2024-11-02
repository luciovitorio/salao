<?php

namespace App\Services;

use App\Models\Product;


class CostValueProductService
{
    public static function costValueCalculator($productId, $quantity)
    {
        $product = Product::findOrFail($productId);

        $productValue = $product->cost_price;
        $quantityPerService = $product->qtd_service;
        $multiplier = $quantity / $product->qtd_used_per_service;

        return ($productValue / $quantityPerService) * $multiplier;
    }
}
