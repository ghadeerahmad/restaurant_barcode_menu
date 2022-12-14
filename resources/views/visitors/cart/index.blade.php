@extends('layouts.app_layout')
@section('title',__('cart.cart'))
@section('css')
<style>

    .q-btn{
        background-color: transparent;
    border: 1px solid #000;
    border-radius: 150px;
    height: 25px;
    width: 25px;
    text-align: center;
    margin: 0px 10px;
    }
    #quantity-input{
        background-color: transparent;
        border: none;
        text-align: center;
        display: inline-block;
        width: 25px;
    }
    .tab_container{
        padding: 20px 35px;
    }
    .cart{
        padding: 0;
    }
    .btn-checkout{
        visibility: hidden;
    }
    @media (min-width:768px){
        
   
    }
</style>
@endsection
@section('content')
<div class="container-fluid cart">
    <div class="container tab_container">
            @foreach($cart as $value)
            @php $total = 0; @endphp
                <div class="row info-product" style="direction:{{App::isLocale('ar')?'rtl':'ltr'}};position:relative">
                
                        <div class="delete-btn">
                            <form method="POST" action="{{url('cart/delete',$value->id)}}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="" title="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </div>

                
                    <div class="col-4">
                        <img src="{{asset('storage'.$value->product->image)}}" width="100%">
                    </div>
                    <div class="col-8">
                        <h3 class="category-name" style="direction:{{App::isLocale('ar')?'rtl':'ltr'}}">{{get_local_name($value->product->product_category->name_ar,$value->product->product_category->name_ar)}}</h3>
                        <p style="text-align: start;direction:{{App::isLocale('ar')?'rtl':'ltr'}}">{{get_local_name($value->product->name_ar,$value->product->name_en)}}</p>
                        @if(count($value->sizes) > 0)
                        <p><strong>{{__('cart.sizes')}}</strong></p>
                        <ul style="text-align: start;">
                            @foreach($value->sizes as $size)
                            <li>{{get_local_name($size->size->name_ar,$size->size->name_en)}}</li>
                            @php $total += $size->size->price * $value->quantity; @endphp
                            @endforeach
                        </ul>
                        @endif
                        @if(count($value->addons) > 0)
                        <hr>
                        <p><strong>{{__('cart.addons')}}</strong></p>
                        <ul style="text-align: start;">
                            @foreach($value->addons as $addon)
                            <li>{{get_local_name($addon->addon->name_ar,$addon->addon->name_en)}}</li>
                            @php $total += $addon->addon->price * $value->quantity; @endphp
                            @endforeach
                        </ul>
                        @endif
                        @if(count($value->edits) > 0)
                        <p><strong>{{__('cart.edits')}}</strong></p>
                        <ul style="text-align: start;">
                            @foreach($value->edits as $edit)
                            <li>{{get_local_name($edit->edit->name_ar,$edit->edit->name_en)}}</li>
                            @endforeach
                        </ul>
                        @endif
                        @if(count($value->sauces) > 0)
                        <p><strong>{{__('cart.sauces')}}</strong></p>
                        <ul style="text-align: start;">
                            @foreach($value->sauces as $sauce)
                            <li>{{get_local_name($sauce->sauce->name_ar,$sauce->sauce->name_en)}}</li>
                            @php $total += $sauce->sauce->price * $value->quantity; @endphp
                            @endforeach
                        </ul>
                        @endif
                        <hr>
                        <p style="text-align: start;"><strong>{{__('cart.quantity')}}</strong>: <button class="q-btn" id="more" onclick="increase({{$value->id}})"><i class="fa fa-plus"></i></button><input type="number" value="{{$value->quantity}}" id="quantity-input"><button class="q-btn" id="less" onclick="decrease({{$value->id}})"><i class="fa fa-minus"></i></button></p>
                    
                        <hr>
                        @php $total += $value->product->price * $value->quantity; @endphp
                        
                        <p><strong>{{__('cart.price')}}: </strong>
                            <span id="price">{{$total.' '.$value->store->currency->code}}</span>
                        </p>
                    </div>
                    
                </div>
                @endforeach
                <div class="col-md-12">

                    <div class="mt-4">
                        <a href="{{session('table')==null?route('orders.create',session('store_id')):route('table.orders.create',session('store_id'))}}" class="btn-checkout">{{__('cart.continue')}}</a>

                    </div>
        </div>
    </div>
</div>
<div class="floating-div">
<a href="{{session('table')==null?route('orders.create',session('store_id')):route('table.orders.create',session('store_id'))}}" class="floating-btn">{{__('cart.continue')}}</a>
</div>
@endsection
@section('js')
<script>
    function increase(id){
        var qnt = parseInt($("#quantity-input").val());
            qnt = qnt + 1;
            $("#quantity-input").val(qnt);
            $.ajax({
                type:"POST",
                url:"{{url('cart/update')}}/"+id,
                data:{
                    'quantity':qnt,
                    _token:'<?php echo csrf_token();?>'
                },
                success:function(data){

                }
            });
    }
    function decrease(id){

        var qnt = parseInt($("#quantity-input").val());
            if(qnt > 1){
                qnt = qnt - 1;
                $("#quantity-input").val(qnt);
                $.ajax({
                type:"POST",
                url:"{{url('cart/update')}}/"+id,
                data:{
                    'quantity':qnt,
                    _token:'<?php echo csrf_token();?>'
                },
                success:function(data){
                    
                }
            });
            }
    }
    $(document).ready(function(){

        
        $("#less").click(function(){
        });
    });
</script>
@endsection