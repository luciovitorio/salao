<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsPaidAttribute($value)
    {
        return $value === 1 ? true : false;
    }

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
        return $this->belongsToMany(Product::class, 'service_products')
            ->withPivot('used_quantity', 'cost_price')
            ->withTimestamps();
    }
}
