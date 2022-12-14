@extends('layouts.app_layout')
@section('css')

<style>
    #map {
        background-color: transparent;
        height: 100%;
    }
    #small_map_container{
        border-radius: 35px;
        width: 100%;
        height: 100px;
        overflow: hidden;
        display: none;
        
    }
 #small_map{
     width: 100%;
     height: 100%;
 }
    body {
        background-repeat: repeat-y;
    }

    .form-control {
        border-radius: 35px;

        direction: {{App::isLocale('ar')?'rtl':'ltr'}};
        border-color:#000;
        height:50px;
        padding:10px 20px;
    }

    form,
    form * {
        text-align: start;

        direction: {{App::isLocale('ar')?'rtl':'ltr'}};
    }

    .btn-primary {
        height: 50px;
        border-radius: 35px;
        visibility: hidden;
    }

    .map-container {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        background-color: #fff;
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
        z-index: -1;
        opacity: 0;
    }

    .submit-location {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px 25px;
        text-align: center;
    }

    .submit-location button{
        background-color: #fcc02c;
        color: #000;
        border-radius: 35px;
        text-align: center;
        padding: 10px 25px;
        text-align: center;
        border: none;
    }
    .map-container #close-map{
        position: fixed;
        top: 10px;
        left: 10px;
        background-color: #fcc02c;
        color: #000;
        height: 25px;
        width: 25px;
        border: none;
        border-radius: 150px;
        z-index: inherit;
        text-align: center;
    }
    .item {
        border-radius: 35px;
        text-align: center;
        display: block;
        padding: 10px 20px;
        background-color: #fff;
        color: #000;
        height: 100%;
    }
    .item p {
        text-align: center;
        font-size: 13px;
    }
    .location-alert{
        position: fixed;
        display: flex;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: #0000007a;
        opacity: 0;
        z-index: -1;
        
    }
    .location-alert div{
        margin: auto;
        background-color: #fff;
        color: #000;
        border-radius: 35px;
        padding: 20px 30px;
        text-align: center;
        z-index: inherit;
    }
    .location-alert button{
        background-color: #fcc02c;
        color: #000;
        border: none;
        border-radius: 35px;
        padding: 10px 20px;
    }
    @media (min-width:768px) {
        .btn-primary {
            visibility: visible;
        }
    }
</style>
@endsection
@section('content')
<div class="container-fluid cart">
    <div class="tab_container">
        <form method="POST" id="order_form" action="{{route('table.orders.create',$store->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8 col-md-12">
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="{{__('orders.name')}}" value="{{old('customer_name')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="customer_phone" id="phone" class="form-control" placeholder="{{__('orders.phone')}}" value="{{old('customer_phone')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="table_code" id="table_code" class="form-control" placeholder="{{__('orders.table_code')}}" value="{{old('table_code')}}">
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="{{__('orders.coupon_code')}}" value="{{old('coupon_code')}}">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" onclick="check_coupon();">{{__('orders.check')}}</button>
                        </div>
                    </div>

                    <p class="alert alert-danger hide" id="alert-danger">{{__('orders.coupon_fail')}}</p>
                    <p class="alert alert-success hide" id="alert-success">{{__('orders.coupon_success')}}</p>

                </div>
                <div class="col-lg-4 col-md-12 info-product">
                    <h4>{{__('orders.order_details')}}</h4>
                    <p><strong>{{__('orders.store_name')}}: </strong>{{App::isLocale('ar')?$store->name_ar:$store->name_en}}</p>
                    <p><strong>{{__('orders.products')}}</strong></p>
                    <div class="container">
                        <ul>
                            @php $total = 0; $tax = 0; $delivery = 0;@endphp
                            @foreach($items as $item)
                            @if($item->product->tax != null && $item->product->tax != 0) @php $tax += $item->product->tax; @endphp @endif
                            
                            <li>{{App::isLocale('ar')?$item->product->name_ar:$item->product->name_en}}
                                <p>{{__('orders.quantity')}}: {{$item->quantity}}</p>
                                <p>{{__('orders.addons')}}:
                                    @foreach($item->addons as $addon)
                                    {{App::isLocale('ar')?$addon->addon->name_ar:$addon->addon->name_en}},
                                    @php $total += $addon->addon->price * $item->quantity; @endphp
                                    @endforeach
                                </p>
                                <p>{{__('orders.edits')}}:
                                    @foreach($item->edits as $edit)
                                    {{App::isLocale('ar')?$edit->edit->name_ar:$edit->edit->name_en}},
                                    @endforeach
                                </p>
                                <p>{{__('orders.sauces')}}:
                                    @foreach($item->sauces as $sauce)
                                    {{App::isLocale('ar')?$sauce->sauce->name_ar:$sauce->sauce->name_en}},
                                    @endforeach
                                </p>
                                <p>{{__('orders.price')}}:
                                    @if($item->product->discount != 0 && $item->product->discount != null)
                                    <sapn style="text-decoration:line-through;">
                                        {{$item->product->price}}
                                    </sapn> {{calc_discount($item->product->price,$item->product->discount,$item->product->discount_type)}} {{$store->currency->code}}
                                    @php $total += calc_discount($item->product->price,$item->product->discount,$item->product->discount_type) * $item->quantity; @endphp
                                    @else
                                    {{$item->product->price.' '.$store->currency->code}}
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    @endif
                                </p>
                            </li>
                            @endforeach
                            @php $total += $tax; @endphp
                        </ul>
                    </div>
                    <div style="border:1px solid #000;width:100%;height: 1px;"></div>

                    <p>
                    <h5 style="display: inline-block;">{{__('orders.tax')}}: </h5> {{$tax}} {{$store->currency->code}}</p>
                    <p>
                    <h5 style="display: inline-block;">{{__('orders.discount')}}: </h5> <span id="discount">0 {{$store->currency->code}}</span></p>

                    <p>
                    <h3 style="display: inline-block;">{{__('orders.total')}}: </h3> <span id="total">{{$total}}</span> {{$store->currency->code}}</p>
                    @if($store->tax_note != null && $tax != 0)
                    <p>{{$store->tax_note.': '.$tax.' '.$store->currency->code}}</p>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{__('orders.checkout')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="floating-div">
    <button type="button" class="floating-btn" id="order_now"><i class="fab fa-whatsapp" style="font-size: 25px;margin:0px 10px"></i> {{__('orders.checkout')}}</button>
</div>
<div class="location-alert" id="errorMessage">
    <div>
        <p id="message"></p>
        <button type="button" id="error-close">{{__('orders.ok')}}</button>
    </div>
</div>  
@endsection
@section('js')
@include('visitors.orders.scripts.create')
@endsection