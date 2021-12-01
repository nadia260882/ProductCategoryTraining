<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\productCategories as Authenticatable;


class productCategories extends Model
{
    use HasFactory;
    public $timestamps= false;  
    protected $table = 'productcategories';
  
    protected $fillable = [
        'id','catId','productId'
    ];
}
