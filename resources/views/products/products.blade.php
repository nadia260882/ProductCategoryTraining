@extends('layouts.applayout')
@section('style')
<style>
	table tfoot tr th input {
    font-size: 16px !important;
  }

  table tfoot tr th input {
    width: 100% !important;
  }
  tfoot {
    display: table-header-group;
  }

  .add-save-button{
	  margin-left:15px;
  }
}
</style>
@stop
@section('title', 'Product List')
@section('navbar')
    @include('include.navbar')
@stop

@section('sidebar')
    @include('include.sidebar')
@stop

@section('content')
	@include('include.flash_message')
<?php //dd($products); ?>

<!-- The Modal -->
<div class="modal fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">								
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Warning..!!!</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>										
			<!-- Modal body -->
			<div class="modal-body">
				<b>Are you really want to delete this record....???</b>
			</div>									
			<!-- Modal footer -->
			<div class="modal-footer">
				<a href="" id="modalYes">
					<button type="button" class="btn btn-default" name="delete" id="catDelete">Yes</button>
				</a>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>										
		</div>
	</div>
</div>
<div class="card">
	<!-- card-header -->

    <div class="card-header">
		<h3 class="card-title"><h1>List Of Products</h1></h3>
		<div class="row float-right">
			<button type="button" class="btn btn-info add-save-button" onclick="clearFilter()"><lable>Reset Filter</lable></button>
			<a type="button" class="btn btn-info add-save-button" href="{{route('productadd')}}">Add</a>
		</div>
    </div>
    <!-- /.card-header -->

	<!-- card-body -->
    <div class="card-body">
        <table id="example2" class="table table-bordered table-striped text-center">
		<thead>
			<tr>
				<th>Image</th>
				<th>Product Name</th>
				<th>Product Code</th>
                <th>Category Name</th>
				<th>Quantity</th>
				<th>Added Date</th>
				<th>Modify Date</th>
				<th>Unit Price</th>													
				<th>Sale Price</th>
                <th>Order Unit</th>
				<th>Status</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th></th>
				<th class="filter" filter-type="text">Product Name</th>
				<th class="filter" filter-type="text">Product Code</th>
                <th class="filter" filter-type="text">Category Name</th>
				<th class="filter" filter-type="text">Quantity</th>
				<th class="filter" column="Add_Date">Add_Date</th>
				<th class="filter" column="Mod_Date">Mod_Date</th>
				<th class="filter" filter-type="text">Unit Price</th>													
				<th class="filter" filter-type="text">Sale Price</th>
                <th class="filter" filter-type="text">Order Unit</th>
				<th class="filter" filter-type="dropdown" column="status">Status</th>
				<th></th>
				<th></th>
			</tr>
		<tbody>
		</tbody>		
		</table><!-- /.card-body -->
	</div>
</div>

@stop

@section('footer')
    @include('include.footer')
@stop

@section('script')
<script src="{{url('public/assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
	var table;
	jQuery(document).ready(function(e){
    	fetchData();
    	//Date picker
		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			todayHighlight: true,
			autoclose: true,
			autocomplete: "off",
			weekStart: 1,
    	});
	});
	function fetchData(){
		table = $('#example2');		
		table = jQuery('#example2').DataTable({   
			lengthChange: true,
			autoWidth: false, 
			responsive: true,
			processing: true,
			serverSide: true,
			searching: true,
			stateSave: true,
			'serverMethod': 'post',
			ajax:{
						"headers": {
							"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
						},
						"url":'products/getProducts',
						"async": false,
						"beforeSend": function () {
							if ($('#example2').DataTable().settings()[0].jqXHR) {
								$('#example2').DataTable().settings()[0].jqXHR.abort();
							}
						}
				},
			columns: [
			// {data: 'id', orderable: false, className: 'text-center'},
				{data: 'imageName',orderable: false},
				{data: 'productName'},
				{data: 'productCode'},
				{data: 'catName'},
				{data: 'quantity'},
				{data: 'added_date'},
				{data: 'modify_date'},
				{data: 'unitPrice'},
				{data: 'salePrice'},
				{data: 'orderUnit'},
				{data: 'productStatus'},
				{data: 'edit', orderable: false},
				{data: 'delete', orderable: false},
			],
			columnDefs: [
				{ targets: [0], searchable: false, sortable: false },
				{ targets: [11], searchable: false, sortable: false },
				{ targets: [12], searchable: false, sortable: false },
				{ width: "5%", targets: 0 },
			],
			order: [[2, 'asc']]
		});
		var state = table.state.loaded();

	if (state) {
		state = state.columns;
	}
	$('#example2 tfoot .filter').each(function (){
		var title = $(this).text();
		var index = $(this).index();
		var dd = state ? state[index].search.search : '';

		if ($(this).attr('filter-type') == 'dropdown'){
			var html = '<select class="form-control select-input select2" id="column_' + index + '">';
			dd = parseInt(dd);
			if ($(this).attr('column') == 'status'){
				if (dd == 1) {
					html += '<option value=1 selected="selected">Active</option>';
				}
				else{
					html += '<option value=1>Active</option>';
				}
				if (dd == 0){
					html += '<option value=0 selected="selected">Inactive</option>';
				} else {
					html += '<option value=0>Inactive</option>';
				}
			}
			html += '</select>';
			$(this).html(html);
			// _select2(".select2")	
		}
		if($(this).attr('filter-type') == 'text') {
			$(this).html('<input type="text" class="form-control search-input ellipsis_cl" value="' + dd + '" id="column_' + index + '" placeholder="' + title + '" style="width:100%;" />');
		}
		if ($(this).attr('column')=='Add_Date'){
			$(this).html('<input type="text" class="form-control datepicker date_picker" placeholder="' + title + '" value="' + dd + '"/>');
		}
		if ($(this).attr('column')=='Mod_Date'){
			$(this).html('<input type="text" class="form-control datepicker date_picker" placeholder="' + title + '" value="' + dd + '"/>');
		}			
		
		table.columns().every(function (){			
			var obj = this;
			$('input', this.footer()).on('keyup change clear', function () {
				if (obj.search() !== this.value) {					
					var ths = this;			
					obj.search(ths.value).draw();		
				}
			});
			$('select', this.footer()).on('change clear', function () {
				if (obj.search() !== this.value) {
					console.log(this.value);
					obj.search(this.value).draw();
				}
			});				
		});
	});	
}	
// <!-- Modal -->
function callModal(id){
		$("#myModal").modal('show');
		//console.log(id);
		$('#modalYes').attr("href","{{ route('productdelete','')}}"+"/"+id);
	}
	$(document).ready(function(){
		$('#alertArea').fadeOut(10000);
	});
	function clearFilter( type ) {  
		$(".search-input").val("").change();
		$(".select-input").val("").change();
		$(".date_picker").val("").change();
	}
</script>
@stop

