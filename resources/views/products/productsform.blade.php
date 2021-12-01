@extends('layouts.applayout')

@section('title', 'Product Form')
@section('navbar')
    @include('include.navbar')
@stop

@section('sidebar')
    @include('include.sidebar')
@stop

@section('content')
@include('include.flash_message')

<?php 
//dd($products);
?>
<h1> Product Add/Edit</h1>
<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add/Edit Product</h3>
                </div>
            <!-- /.card-header -->
            <!-- form start -->
                <form method="post" enctype="multipart/form-data" action="{{ route('productstore')}}">
                    @csrf <!-- {{ csrf_field() }} -->
                    <input type="hidden" name="productID" value="{{ $products->id ?? 0 }}">

                    <!-- <input type="hidden" name="productCode" value="{{ $id ?? 0 }}"> -->
                    <div class="card-body">           
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catName">Product Name</label>
                            <input type="text" class="form-control" id="productName" placeholder="Enter Product Name" name="productName" value="{{ isset($products->productName) ? $products->productName : '' }}"> 
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catID">Category Name</label>
                            <select class="form-control select2" data-placeholder="Select a category"  multiple="multiple" name="catID[]" data-dropdown-css-class="select2-purple"  style="width: 100%;" >
                            
                            @foreach($catData as $data)
                                <option value="{{$data->id}}"
                                {{ isset($products) && $products->catID == $data->id ? "selected" : ''}}>
                                    {{$data->catName}}
                                </option>
                            @endforeach
                            </select>    
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="img">Product Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" multiple="multiple" onchange="readURL(this)" class="custom-file-input" id="img"
                                    placeholer="img" name="productImg[]" accept="image/x-png,image/jpeg" value="">  
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>          
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="img">Image</label>                            
                            <div class="col-sm-10">                               
                            @if(isset($image) && $ModificationMode=='edit')
                            @foreach($image as $i)
                                <img id="" alt="" src="{{ asset('/public/productImages/'. $i->imageName) }}" name="oldImage" height=100 width=150> 
                            @endforeach
                            @else
                                <img id="blah" alt="" src="" name="oldImage"> 
                            @endif
                            </div>

                           
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="quantity">Quantity</label>
                                <input type="text" class="form-control" id="quantity" placeholder="Enter Qty" name="quantity" value="{{ isset($products->quantity) ? $products->quantity : '' }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="unitPrice">Unit Price</label>
                                <input type="text" class="form-control" id="unitPrice" placeholder="" name="unitPrice" value="{{ isset($products->unitPrice) ? $products->unitPrice : '' }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="salePrice">Sale Price</label>
                                <input type="text" class="form-control" id="salePrice" placeholder="" name="salePrice" value="{{ isset($products->salePrice) ? $products->salePrice : '' }}">
                        </div>
                    
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="salePrice">Unit On Order</label>
                                <input type="text" class="form-control" id="salePrice" placeholder="" name="orderUnit" value="{{ isset($products->orderUnit) ? $products->orderUnit : '' }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sel1">Status (select one):</label>
                                <select class="form-control" id="sel1" name="productStatus">
                                    <option value="0" {{ isset($products) && $products->productStatus=="0" ? "selected" : ''  }}>0 - Inactive</option>
                                    <option value="1" {{ isset($products) && $products->productStatus=="1" ? "selected" : ''  }}>1 - Active</option>
                                </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- bs-custom-file-input -->
<script src="{{ url('public/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@stop
@section('footer')
    @include('include.footer')
@stop
@section('script')
<script>
    $(function () {
        bsCustomFileInput.init();
    });
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(100)
                .height(150);
        };        
        reader.readAsDataURL(input.files[0]);
    }
}
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
  $(document).ready(function(){
		$('#alertArea').fadeOut(10000);
	});

</script>
@stop