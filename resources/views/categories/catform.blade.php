@extends('layouts.applayout')

@section('title', 'Category Add/Edit')
@section('navbar')
    @include('include.navbar')
@stop

@section('sidebar')
    @include('include.sidebar')
@stop

@section('content')
@include('include.flash_message')

<?php //dd($catName) ?>
   <!-- @if ($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   
   @if (count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif -->


<!-- <h1> Category </h1> -->
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Category</h3>
                </div>
            <!-- /.card-header -->
            <!-- form start -->
                <?php //dd($ModificationMode); ?>
                <!-- @if($ModificationMode=='add')
                    <form method = "post" action="{{ route('catstore') }}">
                @else
                @endif             -->
                <form action="{{ route('catstore') }}" method="post" enctype="multipart/form-data">

                @csrf <!-- {{ csrf_field() }} -->
                    <input type="hidden" name="id" value="{{ $id ?? 0 }}">

                <!-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> -->
                    <div class="card-body">
                        <div class="form-group">

                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter Category Name" name="catName" value="{{ isset($categories->catName) ? $categories->catName : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Category Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" onchange="readURL(this)" name="catImage" accept="image/x-png,image/jpeg" value="{{ isset($categories->catImage) ? $categories->catImage : '' }}">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catImage">Image</label>
                            <div class="col-sm-10">          
                                <img id="blah" src="{{ isset($categories->catImage) ? asset('public/catImages/'. $categories->catImage) : '' }}" name="oldImage">
                            </div> 
                        </div>

                        <div class="form-group">
                            <label for="categoryOrder">Order Unit</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter Order Unit" name="order_no" value="{{ isset($categories->order_no) ? $categories->order_no : '' }}">
                        </div>
                    
                        <div class="form-group">
                            <!-- select -->
                            <div class="form-group">
                                <label>Status(Select One)</label>
                                <select class="form-control" name="catStatus" value="">
                                <option value="0" {{ isset($categories) && $categories->catStatus=="0" ? "selected" : ''  }}>0 - Inactive</option>                                    <option value="1" {{ isset($categories) && $categories->catStatus=="1" ? "selected" : '' }}>1 - Active</option>
                                </select>                                 
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
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
$(document).ready(function(){
		$('#alertArea').fadeOut(10000);
	});

</script>
@stop