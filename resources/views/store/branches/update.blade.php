@extends('layouts.storeAdmin')
@section('title',__('branches.update'))
@section('css')
@include('store.dashboard.widgets.image_crop_css')
@include('store.jscript.map')
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form action="{{url('store/branches/update',$branch->id)}}" method="POST">
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
            @error('errors')
            <div class="alert alert-warning d-flex align-items-center alert-dismissible" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    {{$message}}
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">{{__('branches.logo')}}</label>
                    <input type="hidden" id="logo" name="logo" value="{{$branch->logo}}">
                    <div class="image_area">

                        <label for="upload_image">
                            <img src="@if($branch->logo != null) {{ asset('storage'.$branch->logo) }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" width="100%" />

                            <input type="file" class="image" id="upload_image" style="display:none" />
                        </label>

                    </div>

                </div>
                <div class="col-md-10">
                    @include('store.branches.widgets.name')
                </div>
            </div>
            @include('store.branches.widgets.description')
            @include('store.branches.widgets.address')
            @foreach($roles as $role)
            @if($role->role->code == 'delivery')
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="delivery_fees" value="{{$branch->delivery_fees}}" placeholder="{{__('branches.delivery_fees')}}" aria-label="{{__('branches.delivery_fees')}}" aria-describedby="basic-addon1">
                <span class="input-group-text" id="basic-addon1">{{$branch->currency->code}}</span>
            </div>

            <div class="mb-3">
                <label class="form-label">{{__('branches.delivery_area')}} <span id="area">{{$branch->delivery_area??0}}</span> km</label>
                <input type="range" class="form-range" name="delivery_distance" value="{{$branch->delivery_area??0}}" onchange="addCircle(this.value)">
            </div>
            @endif
            @endforeach
            <div class="mb-3">
                <input type="hidden" id="lat" name="latitude" value="{{$branch->latitude}}">
                <input type="hidden" id="lng" name="longtude" value="{{$branch->longtude}}">
                <label class="form-label">{{__('chef.location_on_map')}}</label>
                <div id="map"></div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
            </div>
        </form>
    </div>
    @include('store.dashboard.widgets.image_crop')
</section>
@endsection
@section('js')
@include('store.jscript.image_crop')
@include('store.dashboard.widgets.image_crop')
@endsection