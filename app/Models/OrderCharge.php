<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCharge extends Model
{
    use HasFactory;
    protected $guarded = [];  

    public function charge(){
        return $this->hasOne(Charge::class,'id','charge_id');
    }
}
