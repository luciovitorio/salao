<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'sale_date',
        'description',
        'is_paid',
        'payment_type',
    ];

    public function getPaymentTypeAttribute($value)
    {
        $types = [
            'money' => 'Dinheiro',
            'pix' => 'Pix',
            'credit_card' => 'Cartão'
        ];

        return $types[$value] ?? $value;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_products')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
