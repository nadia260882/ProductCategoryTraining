@extends('layouts.applayout')

@section('title', 'About Us')

@section('sidebar')
    @parent <!-- Includes parent sidebar -->

    <p>About us page sidebar</p>
@stop

@section('content')
    <p>This is about us content page.</p>
@stop