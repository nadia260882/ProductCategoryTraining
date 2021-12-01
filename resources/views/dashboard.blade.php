@extends('layouts.applayout')

@section('title', 'Dashboard')
@section('navbar')
    @include('include.navbar')
@stop

@section('sidebar')
    @include('include.sidebar')
@stop

@section('content')
    @include('include.flash_message')
    @if(isset(Auth::user()->email))
    <div class="wrapper text-center">
        <strong>Welcome {{ Auth::user()->name }}</strong>
        <br />
        <a href="{{ route ('logout') }}">Logout</a>
    </div>
@else
    <script>window.location = "{{ url('/') }}";</script>
@endif

@stop

@section('footer')
    @include('include.footer')
@stop

@section('script')
<script>
  	$(document).ready(function(){
		$('#alertArea').fadeOut(10000);
	});
</script>
@stop


