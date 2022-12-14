@extends('layouts.app_layout')
@section('css')

@include('visitors.scripts.map')
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
        border-radius: 10px;
        text-align: center;
        display: block;
        padding: 10px 20px;
        background-color: #fff;
        color: #000;
        height: 100%;
        display: flex;
    }
    .item p {
        text-align: center;
        font-size: 13px;
        margin: auto;
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

<div class="map-container" id="select-location">
    <button id="close-map" type="button">X</button>
    <div id="map"></div>
    <div class="submit-location">
        <input type="text" class="form-control" id="address" name="address" placeholder="{{__('orders.address')}}">
        <br>
        <button id="submit-location">{{__('orders.submit_location')}}</button>
    </div>
</div>
<div class="container cart" style="padding: 0;">
    <div class="tab_container">
        <form id="order_form" method="POST" action="{{route('orders.create',$store->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row @if(!App::isLocale('ar')){{'info-group'}}@endif">
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
                    <div class="row @if(!App::isLocale('ar')){{'info-group'}}@endif">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="{{__('orders.name')}}" value="{{old('customer_name')}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="customer_phone" id="phone" class="form-control" placeholder="{{__('orders.phone')}}" value="{{old('customer_phone')}}">
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

                    <div class="form-group">
                        <label class="control-label">{{__('orders.payment_method')}}</label>
                        <select class="form-control" name="payment_method" id="payment_method">
                            @if($settings->is_cash_enabled == 1)
                            <option value="CASH">{{__('orders.cash')}}</option>
                            @endif
                            @if($settings->other_payment_enabled == 1)
                            @foreach($payment_methods as $value)
                            <option value="{{$value->id}}">{{get_local_name($value->title_ar,$value->title_en)}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @if($settings->other_payement_enabled == 1)
                    <div id="payment_details" style="display: none;">
                        <div class="row @if(!App::isLocale('ar')){{'info-group'}}@endif">
                            <div class="col-lg-6 col-md-6" id="info-image-container" style="display: none;">
                                <img id="info-image" width="100%">
                            </div>
                            <div class="col-lg-6 col-md-6" id="info-container" style="display: none;"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('orders.payment_number')}}</label>
                            <input type="text" class="form-control" name="payment_number" value="{{old('payment_number')}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('orders.image')}}</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('orders.notes')}}</label>
                            <textarea class="form-control" name="note">{{old('note')}}</textarea>
                        </div>
                    </div>
                    @endif
                    <div class="form-group" @if(session('table') != null){{'style="display:none"'}}@endif>
                        <label class="control-label">{{__('orders.delivery_type')}}</label>
                        <div class="row">
                            @if(check_store_role($store->id,'delivery') && session('table') == null && $settings->is_delivery_enabled == 1)
                            <div class="col-4">
                                <div class="item delivery-type-item">
                                    <input type="radio" name="delivery_type" value="1" id="delivery" class="delivery-type">
                                    <p>{{__('orders.delivery')}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="item delivery-type-item">
                                    <input type="radio" name="delivery_type" class="delivery-type" value="2">
                                    <p>{{__('orders.eat_in_store')}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                            <div class="item delivery-type-item">
                                    <input type="radio" name="delivery_type" class="delivery-type" value="0">
                                    <p>{{__('orders.take_by_hand')}}</p>
                                </div>
                            </div>
                            @else

                            <div class="col-6">
                            <div class="item delivery-type-item">
                                    <input type="radio" name="delivery_type" value="0" class="delivery-type">
                                    <p>{{__('orders.take_by_hand')}}</p>
                                </div></div>
                            <div class="col-6">
                                <div class="item">
                                    <input type="radio" @if(session('table') != null){{'checked'}}@endif name="delivery_type" value="2" class="delivery-type">
                                    <p>{{__('orders.eat_in_store')}}</p>
                                </div></div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                    <div id="small_map_container">
                        <div id="small_map"></div>
                    </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comments" placeholder="{{__('orders.comment')}}" style="min-height: 150px;"></textarea>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 info-product">
                    <h4>{{__('orders.order_details')}}</h4>
                    <p><strong>{{__('orders.store_name')}}: </strong>{{App::isLocale('ar')?$store->name_ar:$store->name_en}}</p>
                    <p><strong>{{__('orders.products')}}</strong></p>
                    <div class="container">
                        <ul>
                            @php $total = 0; $tax = 0; $delivery = 0;@endphp
                            @foreach($items as $item)
                            @php $price = 0; @endphp
                            <li><strong>{{get_local_name($item->product->name_ar,$item->product->name_en)}}: </strong>
                                <span>{{__('orders.quantity')}}: {{$item->quantity}}</span>
                                @if(count($item->addons) > 0)
                                <p>{{__('orders.addons')}}:</p>
                                <ul>
                                    @foreach($item->addons as $addon)
                                    <li>{{get_local_name($addon->addon->name_ar,$addon->addon->name_en)}} - {{$addon->addon->price.' '.$store->currency->code}}</li>
                                    @php $total += $addon->addon->price * $item->quantity; @endphp
                                    @php $price += $addon->addon->price * $item->quantity; @endphp
                                    @endforeach
                                </ul>
                                @endif
                                @if(count($item->edits) > 0)
                                <p>{{__('orders.edits')}}:</p>
                                <ul>
                                    @foreach($item->edits as $edit)
                                    <li>{{get_local_name($edit->edit->name_ar,$edit->edit->name_en)}}</li>
                                    @endforeach
                                </ul>
                                @endif
                                @if(count($item->sauces) > 0)
                                <p>{{__('orders.sauces')}}:</p>
                                <ul>
                                    @foreach($item->sauces as $sauce)
                                    <li>{{get_local_name($sauce->sauce->name_ar,$sauce->sauce->name_en)}} - {{$sauce->sauce->price.' '.$store->currency->code}}</li>
                                    @php $total += $sauce->sauce->price * $item->quantity; @endphp
                                    @php $price += $sauce->sauce->price * $item->quantity; @endphp
                                    @endforeach
                                </ul>
                                @endif
                                @if(count($item->sizes) > 0)
                                <p>{{__('orders.size')}}:</p>
                                <ul>
                                    @foreach($item->sizes as $size)
                                    <li>{{get_local_name($size->size->name_ar,$size->size->name_en)}} - {{$size->size->price.' '.$store->currency->code}}</li>
                                    @php $total += $size->size->price * $item->quantity; @endphp
                                    @php $price += $size->size->price * $item->quantity; @endphp
                                    @endforeach
                                </ul>
                                @endif
                                    @php $total += $item->product->price * $item->quantity; @endphp
                                    @php $price += $item->product->price * $item->quantity; @endphp
                                <p>{{__('orders.price')}}:
                                    @if($item->product->discount != 0 && $item->product->discount != null)
                                    <sapn style="text-decoration:line-through;">
                                        {{$price}}
                                    </sapn> {{calc_discount($price,$item->product->discount,$item->product->discount_type)}} {{$store->currency->code}}
                                    @php $price += calc_discount($price,$item->product->discount,$item->product->discount_type) * $item->quantity; @endphp
                                    @else
                                    {{$price.' '.$store->currency->code}}
                                    @endif
                                </p>
                            </li>
                            @endforeach
                            @if($store->tax != null)
                            @if($store->tax_type == 'AMOUNT') @php $total += $store->tax; @endphp @endif
                            @if($store->tax_type == 'PERCENT') @php $total += ($store->tax * $total)/100; @endphp @endif
                            @endif
                            
                        </ul>
                    </div>
                    <div style="border:1px solid #000;width:100%;height: 1px;"></div>

                    @if(check_store_role($store->id,'delivery') && session('table') == null && $settings->is_delivery_enabled == 1)
                    <p id="delivery_charge_section" style="display: none;">
                        <strong>{{__('orders.delivery_charge')}}: </strong> <span id="delivery_charge">{{$store->delivery_fees}}</span> {{$store->currency->code}}
                    </p>
                    @endif
                    <h5 style="display: inline-block;">{{__('orders.discount')}}: </h5> <span id="discount">0 {{$store->currency->code}}</span></p>

                    <p>
                    <h3 style="display: inline-block;">{{__('orders.total')}}: </h3> <span id="total">{{$total}}</span> {{$store->currency->code}}</p>
                    <input type="hidden" id="total-price" value="{{$total}}">
                    @if($store->tax_note != null && $store->tax != 0)
                    <p>{{$store->tax_note.': '.$store->tax}} {{$store->tax_type == 'AMOUNT'?$store->currency->code:'%'}}</p>
                    @endif
                    <div class="form-group">
                        <button type="submit" id="submit_form" class="btn btn-primary btn-block">{{__('orders.checkout')}}</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="address" id="address_info">
            <input type="hidden" name="latitude" id="lat">
            <input type="hidden" name="longtude" id="lng">
        </form>
    </div>
</div>

<div class="floating-div">
    <button type="button" class="floating-btn" id="order_now"><i class="fab fa-whatsapp" style="font-size: 25px;margin:0px 10px"></i> {{__('orders.checkout')}}</button>
</div>
<div class="location-alert" id="location-alert">
    <div>
        <p>{{__('orders.enable_location_alert')}}</p>
        <button type="button" id="location-alert-close">{{__('orders.ok')}}</button>
    </div>
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