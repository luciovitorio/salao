<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'qtd_stock',
        'qtd_min',
        'unit_type',
        'quantity',
        'cost_price',
        'sale_price',
        'qtd_service',
        'cost_per_service',
        'qtd_used_per_service'
    ];

    public function getUnitTypeAttribute($value)
    {
        $roles = [
            'ml' => 'ML',
            'un' => 'Unidade'
        ];

        return $roles[$value] ?? $value;
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_products')
            ->withPivot('used_quantity', 'cost_price')
            ->withTimestamps();
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_products')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
