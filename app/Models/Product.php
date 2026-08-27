<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Override;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'description',
        'unit_price',
        'package_price',
        'invima_registration',
        'is_active',
        'strength',
        'unit',
        'user_creator',
    ];

    public function user_creator(){
        return $this->belongsTo(User::class, 'user_creator');
    }
    
    public function name(){
        return Attribute::make(
            set : fn(string $value) => mb_strtoupper($value, 'UTF-8'),
        );
    }
}
