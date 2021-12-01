<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Validate;
use File;
use Image;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;



class CategoriesController extends Controller
{
    function index()
    {
       $categories = Categories::all();
        //return Categories::find(96)->getProduct;
       return view('categories.categories',compact('categories'));

    }

    public function getCategories(Request $request)
    {
        // echo'<pre>'; print_r($request); exit;
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

        $searchName = $request['columns'][1]['search']['value'];
        $searchAddDate = $request['columns'][2]['search']['value'];
        $searchModDate = $request['columns'][3]['search']['value'];
        $searchOrder = $request['columns'][4]['search']['value'];
        $searchStatus = $request['columns'][5]['search']['value'];

        // Total records
        $totalRecords = Categories::select('count(*) as allcount')->count();

        $totalRecordswithFilter = Categories::select('count(*) as allcount')->where('catName', 'like', '%' . $searchValue . '%')->count();
        
        // Get records, also we have included search filter as well

        // $records = Categories::orderBy($columnName, $columnSortOrder);
        $records = Categories::orderBy($columnName, $columnSortOrder);

        $records = $records->select('Categories.*');

        if(isset($searchValue) && !empty($searchValue)) {
            $records = $records->where('Categories.id', 'like', '%' . $searchValue . '%')
            ->orWhere('Categories.catName', 'like', '%' . $searchValue . '%')
            ->orWhere('Categories.order_no', 'like', '%' . $searchValue . '%')
            ->orWhere('Categories.catStatus', 'like', '%' . $searchValue . '%');
        }

        if(isset($searchName) && !empty($searchName)) {
            $records = $records->where('Categories.catName', 'like', '%' . $searchName . '%');
        }
        if(isset($searchAddDate) && !empty($searchAddDate)) {
            $records = $records->whereDATE('Categories.added_date','=', $searchAddDate);
        }
        if(isset($searchModDate) && !empty($searchModDate)) {
            $records = $records->whereDate('Categories.modify_date', '=' , $searchModDate);
        }
        if(isset($searchOrder) && !empty($searchOrder)) {
            $records = $records->where('Categories.order_no', 'like', '%' . $searchOrder . '%');
        }
        if(isset($searchStatus)) {
            $records = $records->where('Categories.catStatus', '=', $searchStatus );
        }
        
        $records = $records->skip($start);
        $records = $records->take($rowperpage);
        $records = $records->get();

        $data_arr = array();

        foreach ($records as $record) {
            $actionButtonEdit = '<div class="btn-group-sm"><a href="' . route('catedit', ['id' => $record->id]) . '" class="btn btn-info btn-xs"> <i class="fa fa-edit"></i>
            </a></div>';

            $actionButtonDelete = '<div class="btn-group-sm"><a href="" class="btn btn-info btn-xs" data-toggle="modal" onclick="callModal('.$record['id'].')"> <i class="fa fa-trash" ></i>
            </a></div>';
            $img='<img src="'.asset('/public/catImages/'. $record->catImage).'" height="60" width="60" />';

            $record->catStatus = $record->catStatus == 1 ? 'Active' : 'Inactive';
            
            $data_arr[] = array(
                "id" => $record->id, 
                "catName" => $record->catName,
                "added_date" => $record->added_date,
                "modify_date" => $record->modify_date,
                "order_no" => $record->order_no,
                "catStatus" => $record->catStatus,
                "catImage" => $img,
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
        $catName = DB::table('categories')
        ->select('categories.catName')
        ->get();        
        $ModificationMode='add';
        return view('categories.catform',compact('ModificationMode','catName'));
    }

    public function store(Request $request)
    {
        $postData = $request->all();
        //dd($postData);
        $id = $request->id;
        //dd($id);
		    try
            {
                $categories = isset($id) && $id != 0 ? Categories::find($id) : new Categories();
                //dd($categories);
                if ( isset($id) && $id==0)
                {
                    $this->validate($request, [
                        'catName' => 'required|unique:categories,catName',
                        'order_no' => 'required',
                        'catImage'=>'required'
                    ]);    

                    $image = $request->catImage;
                    $input['cat_image'] = time() . '.' . $image->extension();
            
                    // Get path of thumbnails folder from /public
                    $thumbnailFilePath = public_path('catImages/thumbnails');
            
                    $img = Image::make($image->path());
            
                    // Image resize to given aspect dimensions
                    // Save this thumbnail image to /public/thumbnails folder
                    $img->resize(110, 110, function ($const) {
                        $const->aspectRatio();
                    })->save($thumbnailFilePath . '/' . $input['cat_image']);
            
                    // Product images folder
                    $ImageFilePath = public_path('catImages');
            
                    // Store product original images
                    $image->move($ImageFilePath, $input['cat_image']);
                    // $image=$request->catImage;
                    // $imageName = time().'.'.$request->catImage->extension();
                    $categories->catImage = $input['cat_image'];
                    // $request->catImage->move(public_path('catImages'), $imageName);
                    $categories->added_date = Carbon::now();
                    $categories->modify_date = Carbon::now();
                }
                else
                {     
                    //dd('edit');
                    $this->validate($request, [
                        'catName' => 'required|unique:categories,catName,'.$id,
                    ]);
                    if(isset($request->catImage)){
                        $imageName = time().'.'.$request->catImage->extension();
                        $categories->catImage = $imageName;
                        $request->catImage->move(public_path('catImages'), $imageName);
                    }
                    $categories->modify_date = Carbon::now();
                }
                $categories->catName = $postData['catName'];
                $categories->order_no = $postData['order_no'];
                $categories->catStatus =$postData['catStatus'];

                $categories->save();
                if(isset($id) && $id==0)
                    return redirect('categories')->with('success', 'Category has been added');
                else
                    return redirect('categories')->with('success', 'Category has been updated');
            }
            catch(Exception $e)
            {
                return redirect('catform')->with('failed',"operation failed");
            }
        }
    // }
    public function edit($id)
    {
        $ModificationMode='edit';
        $categories = Categories::where('id', $id)->first();
        return view('categories.catform', compact('categories','ModificationMode','id'));
    }

    public function delete($id)
    {    
        $categories = Categories::find($id);
        // $categories = Categories::where('id', $id)->delete();

        $image_path = public_path('catImages').'/'.$categories->catImage;
        $thum_image_path = public_path('catImages/thumbnails').'/'.$categories->catImage;

        //dd($image_path);
        
        if (File::exists($image_path)) {
            //dd($image_path);
            File::delete($image_path);
            File::delete($thum_image_path);

            $categories->delete();
        }
        return redirect('categories')->with('success', 'Category has been deleted');
    }

}