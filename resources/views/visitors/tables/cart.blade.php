@extends('layouts.app_layout')
@section('title',__('cart.cart'))
@section('content')
<div class="container title-section mb-5">
    <div class="row justify-content-center">
        <h1>{{__('cart.cart')}}</h1>
    </div>
</div>
<div class="container-fluid cart">
    <div class="container tab_container">

        <div class="row">
            <div class="col-lg-12 col-md-12">
                @foreach($cart as $group => $items)
                <h3 style="color:white">{{__('cart.store_name').': '}}{{get_store_name($group)}}</h3>
                @foreach($items as $value)
                <div class="row info-product justify-content-center">
                    <div class="col-lg-3 col-12">
                        <img src="{{asset('storage'.$value->product->image)}}" width="100%">
                    </div>
                    <div class="col-lg-5 col-12">
                        <h3 class="category-name">{{$locale == 'ar'?$value->product->product_category->name_ar:$value->product->product_category->name_ar}}</h3>
                        <p>{{$locale=='ar'?$value->product->name_ar:$value->product->name_en}}</p>
                        <p><strong>{{__('cart.quantity')}}</strong>: {{$value->quantity}}</p>
                    </div>
                    <div class="col-lg-2 col-12">
                        <div class="pric">
                            <p>{{$value->product->price.' '.$value->store->currency->code}}</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-12">
                        <div class="btn-group">
                            <form method="POST" action="{{url('cart/delete',$value->id)}}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="" title="remove">
                                    <i class="fa fa-times-circle"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                @endforeach
                <div class="col-lg-12 col-md-12">

                    <div class="text-right mt-4">
                        <a href="{{route('table.orders.create',$group)}}" class="btn-checkout">{{__('cart.checkout')}}</a>

                    </div>
                </div>
                @endforeach
            </div>


        </div>
        <!-- <div class="text-center mt-5 mb-4">
            <a href="index-light.html" class="btn-back">{{__('cart.back_to_menu')}}
                <i class="fa fa-arrow-left"></i>
            </a>
        </div> -->
    </div>
</div>

@endsection
@section('js')
<script>
    // var minVal = 1,
    //     maxVal = 100;
    // $(".increaseQty").on('click', function() {
    //     var $parentElm = $(this).parents(".quantity");
    //     $(this).addClass("clicked");
    //     setTimeout(function() {
    //         $(".clicked").removeClass("clicked");
    //     }, 100);
    //     var value = $parentElm.find(".qtyValue").val();
    //     if (value < maxVal) {
    //         value++;
    //     }
    //     $parentElm.find(".qtyValue").val(value);
    // });

    // $(".decreaseQty").on('click', function() {
    //     var $parentElm = $(this).parents(".quantity");
    //     $(this).addClass("clicked");
    //     setTimeout(function() {
    //         $(".clicked").removeClass("clicked");
    //     }, 100);
    //     var value = $parentElm.find(".qtyValue").val();
    //     if (value > 1) {
    //         value--;
    //     }
    //     $parentElm.find(".qtyValue").val(value);
    // });
</script>
@endsection