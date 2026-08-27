<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
    ];
    public function name(){
        return Attribute::make(
            set : fn(string $value) => mb_strtoupper($value, 'UTF-8'),
        );
    }
}
