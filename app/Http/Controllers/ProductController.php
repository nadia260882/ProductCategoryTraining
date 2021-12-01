<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductImage;
use App\Models\ProductCategories;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Carbon\Carbon;
use Validate;
use File;
use Image;


class ProductController extends Controller
{
    public function index()
    {
       // $products = Products::all();
        return view('products.products');
    }
    public function getProducts(Request $request)
    {

        $draw = $request->post('draw');
        $start = $request->post("start");
        $rowperpage = $request->post("length"); // total number of rows per page

        $columnIndex_arr = $request->post('order');
        $columnName_arr = $request->post('columns');
        $order_arr = $request->post('order');
        $search_arr = $request->post('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $searchProductName = $request['columns'][1]['search']['value'];
        $searchProductCode= $request['columns'][2]['search']['value'];
        $searchCatName = $request['columns'][3]['search']['value'];
        $searchQuantity= $request['columns'][4]['search']['value'];
        $searchAddDate = $request['columns'][5]['search']['value'];
        $searchModDate = $request['columns'][6]['search']['value'];
        $searchUnitPrice = $request['columns'][7]['search']['value'];
        $searchSalePrice = $request['columns'][8]['search']['value'];
        $searchOrderUnit = $request['columns'][9]['search']['value'];
        $searchStatus = $request['columns'][10]['search']['value'];
        
        // Total records
        $totalRecords = Products::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Products::select('count(*) as allcount')->where('productName', 'like', '%' . $searchValue . '%')->count();
        
        
        // Get records, also we have included search filter as well       
        $records = Products::orderBy($columnName, $columnSortOrder)
        ->leftjoin("productcategories","products.id","=","productcategories.productID")
        ->leftjoin('categories','categories.id','=','productcategories.catId')
        ->leftJoin('productimages',function($join)
        {
            $join->on('products.id','=','productimages.productId');
            $join->on('productimages.imageStatus','=',DB::raw("'1'"));
        });

        $records=$records->select('products.*','productimages.imageName',DB::raw('GROUP_CONCAT(categories.catName) AS category_name'));

        if(isset($searchValue) && !empty($searchValue)) {
            $records = $records->where('Products.id', 'like', '%' . $searchValue . '%')
            ->orWhere('Products.productName', 'like', '%' . $searchValue . '%')
            ->orWhere('Products.productCode', 'like', '%' . $searchValue . '%')
            ->orWhere('Products.unitPrice', 'like', '%' . $searchValue . '%')
            ->orWhere('Products.salePrice', 'like', '%' . $searchValue . '%')
            ->orWhere('Products.productStatus', 'like', '%' . $searchValue . '%')
            ->orWhere('categories.catName', 'like', '%' . $searchValue . '%');
        }

        if(isset($searchProductName) && !empty($searchProductName)) {
            $records = $records->where('Products.productName', 'like', '%' . $searchProductName . '%');
        }
        if(isset($searchProductCode) && !empty($searchProductCode)) {
            $records = $records->where('Products.productCode', 'like', '%' . $searchProductCode . '%');
        }
        if(isset($searchCatName) && !empty($searchCatName)) {
            $records = $records->where('categories.catName', 'like', '%' . $searchCatName . '%');
        }
        if(isset($searchAddDate) && !empty($searchAddDate)) {
            $records = $records->whereDate('Products.added_date','=', $searchAddDate);
        }
        if(isset($searchModDate) && !empty($searchModDate)) {
            $records = $records->whereDate('Products.modify_date', '=' , $searchModDate);
        }

        if(isset($searchUnitPrice) && !empty($searchUnitPrice)) {
            $records = $records->where('Products.unitPrice', 'like', '%' . $searchUnitPrice . '%');
        }
        if(isset($searchSalePrice) && !empty($searchSalePrice)) {
            $records = $records->where('Products.salePrice', 'like', '%' . $searchSalePrice . '%');
        }
        if(isset($searchOrderUnit) && !empty($searchOrderUnit)) {
            $records = $records->where('Products.orderUnit', 'like', '%' . $searchOrderUnit .'%');
        }
        if(isset($searchStatus)) {
            $records = $records->where('Products.productStatus', '=', $searchStatus );
        }

        $records = $records->groupBy('products.id');
        $records = $records->distinct();
        $records = $records->skip($start);
        $records = $records->take($rowperpage);
        $records = $records->get();
        //dd($records);
        $data_arr = array();

        foreach ($records as $record) {
            $actionButtonEdit = '<div class="btn-group-sm"><a href="' . route('productedit', ['id' => $record->id]) . '" class="btn btn-info btn-xs"> <i class="fa fa-edit"></i>
            </a></div>';

            $actionButtonDelete = '<div class="btn-group-sm"><a href="" class="btn btn-info btn-xs" data-toggle="modal" onclick="callModal('.$record['id'].')"> <i class="fa fa-trash" ></i>
            </a></div>';

            $img='<img src="'.asset('/public/productImages/'. $record->imageName).'" height="60" width="60" />';
            $record->productStatus = $record->productStatus == 1 ? 'Active' : 'Inactive';

            
            $data_arr[] = array(
                // "id" => $record->id,
                "imageName"=>  $img,
                "productName" => $record->productName,
                "productCode" => $record->productCode,
                "catName" => $record->category_name,
                "quantity" => $record->quantity,
                "added_date" => $record->added_date,
                "modify_date" => $record->modify_date,
                "unitPrice" => $record->unitPrice,
                "salePrice" => $record->salePrice,
                "orderUnit" => $record->orderUnit,
                "productStatus" => $record->productStatus,
                "edit"=>$actionButtonEdit,
                "delete"=> $actionButtonDelete
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }
    
    public function create()
    {
        $ModificationMode='add';
        $catData = DB::table('categories')
        ->select('categories.catName','categories.id')
        ->where('categories.catStatus',"=",'1')
        ->get();                
        return view('products.productsform',compact('catData','ModificationMode'));
    }

    public function store(Request $request)
    {
        $postData = $request->all();
       //dd($postData);
        $productID = $request->productID;
        //dd($productID);
        $rules = [
            'productName' =>'required|string|min:3|max:255',
            'quantity' => 'required',
            'unitPrice' => 'required',
            'unitPrice' => 'required',
            'orderUnit' => 'required',
            'productStatus' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        //dd($validator);
        if ($validator->fails())
        {
			return redirect('productsform')
			->withInput()
			->withErrors($validator);
		}
		else
        {     
			try
            {
                $products = isset($productID) && $productID != "0" ? Products::find($productID) : new Products();
                //dd($products);
                if ( isset($productID) && $productID == "0")
                {      
                    //dd('hello');
                    $products->added_date = Carbon::now();
                    $products->modify_date = Carbon::now();
                    $productCode="PROD".rand(100,999);
                    $products->productCode = $productCode;                    
                }
                else
                {  // dd('hi');
                    if(isset($request->productImg))
                    {
                        $imageName = time().'.'.$request->productImg->extension();
                        $products->productImg = $imageName;
                        $request->productImg->move(public_path('productImages'), $imageName);
                    }
                    $products->modify_date = Carbon::now();
                }  
                $products->productName = $postData['productName'];
                $products->quantity = $postData['quantity'];
                $products->unitPrice =$postData['unitPrice'];
                $products->salePrice =$postData['salePrice'];
                $products->orderUnit =$postData['orderUnit'];
                $products->productStatus =$postData['productStatus'];
                //dd($products);
                $products->save();

                if($request->catID)
                {
                    foreach($request->catID as $key=>$catvalue)
                    {
                        $productcategories= new ProductCategories();
                        $productcategories->catId = $catvalue;
                        $productcategories->productId = $products->id;
                        //dd($productcategories);
                        $productcategories->save();
                    }
                } 

                if($request->hasfile('productImg'))
                {

                    foreach($request->file('productImg') as $key=> $image)
                    {
                        $productImage = new ProductImage();
                        $input['product_image']= time().'_'.rand(100,999).'.'.$image->extension();
                        $thumbnailFilePath = public_path('productImages/thumbnails');

                        $img = Image::make($image->path());

                        $img->resize(110, 110, function ($const) {
                            $const->aspectRatio();
                        })->save($thumbnailFilePath . '/' . $input['product_image']);

                        // Product images folder
                        $ImageFilePath = public_path('productImages');
            
                        // Store product original images
                         $image->move($ImageFilePath, $input['product_image']);


                        //echo "<pre>"; print_r($image1);
                        $productImage->imageName =$input['product_image'];
                        // $image->move(public_path('productImages'), $image1);
                        $productImage->productId=$products->id;
                        if($key==0){
                            $productImage->imageStatus = 1;
                        }
                        else{
                             $productImage->imageStatus = 0;
                        }
                        $productImage->save();
                    }               
                    //exit;
                } 
                if ( isset($productID) && $productID == "0"){
                    return redirect('products')->with('success', 'product has been added');
                }
                else{
                    return redirect('products')->with('success', 'product has been updated');

                }
            }
            catch(Exception $e)
            {
                return redirect('productsform')->with('failed',"operation failed");
            }
        }
    }
    public function edit($productCode)
    {
        $ModificationMode='edit';
        $id=$productCode;
        $catData = DB::table('categories')
        ->select('categories.catName','categories.id')
        ->where('categories.catStatus',"=",'1')
        ->get();
        $products = Products::where('id', $id)->first();
        $image = ProductImage:: where('productId',$id)->get();
        //dd($image);
        return view('products.productsform', compact('products','ModificationMode','id','catData','image'));
    }

    public function delete($id)
    {
        $products = Products::find($id);
        //dd($products);
        $productId=$id;
        $productimages = ProductImage :: where('productId',$id)->get();
        //dd($productimages);
        foreach($productimages as $image){
            $image_path = public_path('productImages').'/'.$image->imageName;
            $thum_image_path = public_path('productImages/thumbnails').'/'.$image->imageName;

            // echo "<pre>"; print_r($image_path);
            if (File::exists($image_path)) {
                        File::delete($image_path);
                        File::delete($thum_image_path);
            }
        }
        $products->delete();
        return redirect('products')->with('success', 'Product has been deleted');

    }
}
