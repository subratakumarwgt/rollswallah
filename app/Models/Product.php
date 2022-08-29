<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function varient(){
        return $this->belongsTo(Product::class,'varient_of','id');
    }
    public function varients(){
        return $this->hasMany(Product::class,'varient_of','id');
    }
}
