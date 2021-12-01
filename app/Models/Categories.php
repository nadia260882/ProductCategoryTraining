<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Categories as Authenticatable;


class Categories extends Model
{
    use HasFactory;
    public $timestamps= false;
    
    protected $fillable = [
        'id','catName','added_date','modify_date','catImage','order_no','catStatus'
    ];


}

