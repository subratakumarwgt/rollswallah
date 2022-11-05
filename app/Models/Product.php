<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public $exception_fields = ["category","sub_category","centre_id","status"];
   
    public function varient(){
        return $this->belongsTo(Product::class,'varient_of','id');
    }
    public function varients(){
        return $this->hasMany(Product::class,'varient_of','id');
    }
    public function getFields(){
        return array_filter(array_keys($this->attributesToArray()),function($elem){
           return !(in_array($elem,$this->auto_fields) || in_array($elem,$this->exception_fields)) ;
        });
    }
    public function getExceptions(){
        $array = [
            "centre_id" => [
                "type" =>"select",
                "attributes" => [                   
                    "multiple" => "multiple",
                ],
                "model" => "Centre"
            ],
            "status" => [
                "type" => "select",
                "attributes" => [

                ],
                "values" => [
                    0,1
                ]
            ],
            "category" => [
                "type" => "select",
                "attributes" => [
                    
                ],
                "values" => StaticAsset::getAssetsByTitle("product_categories")
            ],
            "sub_category" => [
                "type" => "select",
                "attributes" => [
                    
                ],
                "values" => StaticAsset::getAssetsByTitle("product_sub_categories")
            ]

        ];
    }
    
}
