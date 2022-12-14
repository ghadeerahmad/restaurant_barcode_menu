@extends('layouts.admin')
@section('title',__('settings.settings'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <form id="settings" method="POST" action="{{url('admin/settings/update')}}">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(session()->has('success'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    {{session()->get('success')}}
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        <div class="mb-3">
            <label class="form-label">{{__('settings.branche_cost')}}</label>
            <input type="number" class="form-control" name="branche_cost" id="branche_cost" value="{{$settings[14]->value}}">
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('chef.save')}}</button>
        </div>
    </form>
</div>
@endsection
@section('js')
@include('admin.settings.scripts.index')
@endsection