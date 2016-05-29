@extends('layouts.layout')
<!-- will have condition if the user is login if not show the login page -->
@section('content')
    <!-- Start Header Section -->
    <header id="header-wrap" class="site-header clearfix">
    <a href="{{ URL::to('logout') }}">Logout</a>
    </header>
@endsection