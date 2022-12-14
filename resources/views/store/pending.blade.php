@extends('layouts.storeAdmin')
@section('content')
<div class="container col-md-6 shadow">
    <div class="alert alert-danger text-center">
        <p>{{__('chef.pending_approval')}}</p>
    </div>
</div>
@endsection