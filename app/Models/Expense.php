<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'is_paid',
        'description',
        'due_date',
        'remember_me',
    ];

    public function getIsPaidAttribute($value)
    {
        return $value === 1 ? true : false;
    }

    public function getRememberMeAttribute($value)
    {
        return $value === 1 ? true : false;
    }
}
