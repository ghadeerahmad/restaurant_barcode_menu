@extends('layouts.storeAdmin')
@section('title',__('stores.add'))
@section('css')
@include('store.dashboard.widgets.image_crop_css')
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form action="{{url('store/create')}}" method="POST">
            @csrf
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
                <div class="col-md-4">
                    <label class="form-label">{{__('chef.store_logo')}}</label>
                    <input type="hidden" id="logo" name="logo" value="{{old('logo')}}">
                    <div class="image_area">

                        <label for="upload_image">
                            <img src="@if(old('logo')!= null) {{ asset('storage'.old('logo')) }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" width="100" height="100" />

                            <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                        </label>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')}}" placeholder="{{__('chef.store_name_ar')}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" placeholder="{{__('chef.store_name_en')}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <textarea class="form-control" placeholder="{{__('chef.store_description_ar')}}" name="description_ar">{{old('description_ar')}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <textarea class="form-control" placeholder="{{__('chef.store_description_en')}}" name="description_en">{{old('description_en')}}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.currency')}}</label>
                        <select class="selectpicker form-control" name="currency_id">
                            @foreach($currencies as $c)
                            <option value="{{$c->id}}" {{old('currency_id') == $c->id?'selected':''}}>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.store_lang')}}</label>
                        <select class="selectpicker form-control" name="lang_code">
                            <option>{{__('chef.both_lang')}}</option>
                            <option value="ar" {{old('lang_code') == 'ar'?'selected':''}}>العربية</option>
                            <option value="en" {{old('lang_code') == 'en'?'selected':''}}>English</option>

                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.address_ar')}}</label>
                        <textarea class="form-control" name="address_ar">{{old('address_ar')}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.address_en')}}</label>
                        <textarea class="form-control" name="address_en">{{old('address_en')}}</textarea>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary">{{__('chef.save')}}</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('js')
@include('store.jscript.image_crop')
@endsection