@extends('layouts.storeAdmin')
@section('title',__('coupons.add'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form action="{{url('store/coupons/update',$coupon->id)}}" method="POST">
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
            @include('store.coupons.widgets.name')
            @include('store.coupons.widgets.description')
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{__('coupons.discount')}}</label>
                        <input type="number" class="form-control" name="discount" placeholder="{{__('coupons.discount')}}" value="{{$coupon->discount}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{__('coupons.discount_type')}}</label>
                        <select name="discount_type" class="selectpicker form-control">
                            <option value="PERCENT" {{$coupon->type == 'PERCENT'?'selected':''}}>{{__('coupons.percent')}}</option>
                            <option value="AMOUNT" {{$coupon->type == 'AMOUNT'?'selected':''}}>{{__('coupons.amount')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{__('coupons.code')}}</label>
                    <input type="text" class="form-control" name="code" placeholder="{{__('coupons.code')}}" value="{{$coupon->code}}">
                </div>
                <div class="col-md-3">
                    <div class="mb-3"><br><br>
                    <div class="form-check form-switch">
                    <input class="form-check-input" name="is_active" type="checkbox" id="flexSwitchCheckDefault" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault">{{__('coupons.is_active')}}</label>
                </div>
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
            </div>
        </form>
    </div>
</section>
@endsection