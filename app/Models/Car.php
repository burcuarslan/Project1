<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'plaque_number',
        'user_id',

    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
