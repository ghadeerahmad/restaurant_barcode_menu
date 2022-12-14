@extends('layouts.storeAdmin')
@section('content')
<div class="container col-md-6 shadow">
    <div class="alert alert-danger text-center">
        <p class="text-center">{{__('chef.store_disabled')}}</p>
        <p class="text-center"><a href="{{url('/logout')}}">{{__('chef.logout')}}</a></p>
    </div>
</div>
@endsection