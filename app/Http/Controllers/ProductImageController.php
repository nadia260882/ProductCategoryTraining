<?php

namespace App\Http\Controllers;
use App\Models\ProductImage;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ProductImageController extends Controller
{
    public function saveImg(Request $request){
        $postData = $request->all();
    }
}
