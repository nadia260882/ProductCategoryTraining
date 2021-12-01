<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'productImages';

    public $timestamps= false;

    protected $fillable = [
        'productId','imageName','imageStatus'
    ];
    
    // public function product()
    // {
    //     return $this->belongsTo('App\Models\Products', 'id');
    // }
    
}
