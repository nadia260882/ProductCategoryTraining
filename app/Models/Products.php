<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps= false;

    protected $fillable = [
        'productCode','productName','quantity','added_date','unitPrice','salePrice','orderUnit','productStatus','i_deleted'
    ];
}
