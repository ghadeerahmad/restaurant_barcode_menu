@extends('layouts.app_layout')
@section('title',get_local_name($store->name_ar,$store->name_en))
@section('css')
<style>
    .spinner-border {
        color: #fff;
    }

</style>
@endsection
@section('content')

<!--slider section-->
<div class="container title-section mb-5">
    <div class="row {{App::isLocale('en')?'info-group':''}} justify-content-center">
        <h1>{{get_local_name($store->name_ar,$store->name_en)}}</h1>
    </div>
</div>
<div class="owl-carousel " id="myCarousel1">
    @php $i=0; @endphp
    @foreach($cates as $cate)
    <div class="container" style="padding: 0;">
        <div class="item tab {{$i==0?'active':''}}">
            
            <div class="showSingle" target="{{$cate->id}}">
            
            <img src="{{asset('storage/'.$cate->image)}}">    
            <h1>{{get_local_name($cate->name_ar,$cate->name_en)}}</h1>
        </div>
        </div>
    </div>
    @php $i++; @endphp
    @endforeach
</div>

<!--end slider section-->

<div class="container col-md-10">
    <div class="btn-group">
        <button type="button" class="btn btn-show current" data-show=".list" title="List">
            <i class="fa fa-th-list"></i>
        </button>
        <button type="button" class="btn btn-show" data-show=".grid" title="Grid">
            <i class="fa fa-th"></i>
        </button>
    </div>
    <div class="tab_container">
        @foreach($cates as $cate)
        <!--tab1-->
        <div id="tab{{$cate->id}}" class="targetDiv">
            <!--list style--> 
            <div class="list-style list ">
                @foreach($cate->products as $value)
                <div class="information">
                    <a @if($value->is_active==1) data-toggle="modal" data-target="#show-info" onclick="getInfo({{$value->id}})" @endif>
                    
                        <div class="row" style="{{App::isLocale('ar')?'direction: rtl;':'direction: ltr;'}}overflow:hidden;position:relative">
                        @if($value->is_active == 0)
                <div class="unavailable">
                    <span style="color:#fff">{{__('menu.unavailable')}}</span>
                </div>
                @endif
                        <div class="col-4" style="text-align:start;">
                                <img src="{{asset('storage'.$value->image)}}" width="100%" height="100%">
                            </div>  
                        <div class="col-8" style="padding: 0;">
                                <div class="info-content" style="padding: 10px 0px;text-align:start">
                                    <h1>{{get_local_name($value->name_ar,$value->name_en)}}</h1>
                                    <article style="text-align: justify;width:80%">{{get_local_name($value->description_ar,$value->description_en)}}</article>

                                </div>
                                <div class="price" style="{{App::isLocale('ar')?'left:15px;border-top-left-radius:10px;':'right:15px;border-top-right-radius:10px'}}">
                                    {{$value->price.' '.$store->currency->code}}
                                </div>
                            </div>  
                        </div>
                </div>
                    </a>
                @endforeach
            </div>
            <!-- end list style-->
            <!--grid style-->
            <div class="grid-style grid hide" style="direction: rtl;">

                <div class="row  @if(!App::isLocale('ar')){{'info-group'}}@endif">
                    @foreach($cate->products as $value)
                    <div class="col-6" style="padding:0 15px;">
                    
                        <a class="btn-modal" data-toggle="modal" data-target="#show-info" onclick="getInfo({{$value->id}})">
                            <div class="information">
                                <img src="{{asset('storage'.$value->image)}}" width="100%">
                                <div class="info-content">
                                    <h1>{{get_local_name($value->name_ar,$value->name_en)}}</h1>
                                    <p>{{get_local_name($value->description_ar,$value->description_en)}}</p>

                                </div>
                                <div class="info-pric">
                                    <p>{{$value->price.$store->currency->code}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <!--end list style-->
        </div>
        <!-- end tab1-->
        @endforeach

    </div>
</div>
@php $total = 0; @endphp
@if($cart != null)
@foreach($cart as $item)
@php $total += $item->product->price * $item->quantity; @endphp
@foreach($item->addons as $addon) @php $total += $addon->addon->price * $item->quantity; @endphp @endforeach
@foreach($item->sauces as $sauce) @php $total += $sauce->sauce->price * $item->quantity; @endphp @endforeach
@foreach($item->sizes as $size) @php $total += $size->size->price * $item->quantity; @endphp @endforeach
@endforeach
@endif
@if(calc_work_day())
<div class="floating-div">
    <a href="{{url('cart')}}" class="floating-btn">{{__('cart.checkout')}} (<span id="total_req">{{$total}}</span>)</a>
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="show-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modal-close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="container-fluid" style="direction:{{$locale=='ar'?'rtl':'ltr'}}">
                    <div class="row  @if(!App::isLocale('ar')){{'info-group'}}@endif" id="product-content" style="display: none;">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <img id="product-image" src="image/1.png" width="100%">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="info-content">
                                <h1 id="product-title">سندويش همبرغر</h1>
                                <div id="product-des"></div>

                            </div>
                        </div>
                    </div>
                    <form method="POST" id="cart-form">
                        <input type="hidden" id="product_id">
                        <input type="hidden" id="store_id">
                        <div class="quantity text-center list-unstyled" id="qauntity" style="display: none;">
                            <button type="button" class="btn"> <i class="fa fa-minus decreaseQty"></i></button>
                            <input name="quantity" id="quantity" type="text" class="qtyValue" value="1" readonly />
                            <button type="button" class="btn"> <i class="fa fa-plus increaseQty"></i></button>
                        </div>
                        
                        <div class="additions" id="sizes" style="display: none;">
                            <div class="title">
                                <h1>{{__('menu.sizes')}}</h1>
                            </div>
                            <ul class="list-unstyled" id="sizes-list">

                            </ul>
                        </div>
                        <div class="additions" id="addons" style="display: none;">
                            <div class="title">
                                <h1>{{__('menu.addons')}}</h1>
                            </div>
                            <ul class="list-unstyled" id="addons-list">

                            </ul>
                        </div>

                        <div class="additions" id="edits" style="display: none;">
                            <div class="title">
                                <h1>{{__('menu.edits')}}</h1>
                            </div>
                            <ul class="list-unstyled" id="edits-list">

                            </ul>
                        </div>

                        <div class="additions" id="sauces" style="display: none;">
                            <div class="title">
                                <h1>{{__('menu.sauces')}}</h1>
                            </div>
                            <ul class="list-unstyled" id="sauces-list">

                            </ul>
                        </div>
                        <div class="form-group text-center" id="options" style="display: none;">
                        <input type="hidden" id="product_price" value="0">
                        @if(calc_work_day())
                            <button type="submit" class="btn-cart">{{__('menu.add_to_cart')}} (<span id="cart_price"></span>) {{$store->currency->code}}
                            </button>
                        @endif
                        </div>
                    </form>
                    <div class="text-center" id="loading">
                        <div class="spinner-border" role="status" style="color: white;">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="location-alert" id="errorMessage">
    <div>
        <p id="message"></p>
        <button type="button" id="error-close">{{__('orders.ok')}}</button>
    </div>
</div>
<!--end Modal -->
@endsection
@section('js')
<script>
    var local = '{{$locale}}';
    function displayErrorMessage(message){
        $("#message").html(message);
        $("#errorMessage").attr('style','z-index:99999;opacity:1');
        $("#errorMessage").addClass('popup');
    }
    function get_local_string(string_ar, string_en) {
        if (string_ar != null && string_en != null) return local == 'ar' ? string_ar : string_en;
        if (local == 'ar') {
            if (string_ar != null) return string_ar;
            return string_en;
        }
        if (local == 'en') {
            if (string_en != null) return string_en;
            return string_ar;
        }
    }

    function getInfo(product_id) {
        var checkMark = '<span class="square"><span class="checkmark"><div class="checkmark_stem"></div><div class="checkmark_kick"></div></span></span>';
        $("#loading").attr('style', 'display:block');
        $("#product-content").attr('style', 'display:none');
        $("#qauntity").attr('style', 'display:none');
        $("#options").attr('style', 'display:none');
        $("#addons").attr('style', 'display:none');
        $("#addons-list").attr('style', 'display:none');
        $("#edits").attr('style', 'display:none');
        $("#edits-list").attr('style', 'display:none');
        $("#sauces").attr('style', 'display:none');
        $("#sauces-list").attr('style', 'display:none');
        $("#sizes").attr('style','display:none');
        $("#sizes-list").attr('style','display:none');
        $("#quantity").val(1);
        $.ajax({
            type: "GET",
            url: '{{url("/products")}}/' + product_id,
            success: function(data) {
                console.log(data);
                document.getElementById('product_id').value = product_id;
                document.getElementById('store_id').value = data['store_id'];
                $("#product-image").attr('src', '{{asset("storage")}}' + data['image']);
                document.getElementById('product-title').innerHTML = get_local_string(data['name_ar'], data['name_en']);
                document.getElementById('product-des').innerHTML = get_local_string(data['description_ar'], data['description_en']);
                $("#cart_price").html(data['price']);
                $("#product_price").val(data['price']);
                $("#addons-list").html('');
                $("#edits-list").html('');
                $("#sauces-list").html('');
                $("#sizes-list").html('');
                if (data['sizes'].length == 0 || data['sizes'] == null) $("#sizes").attr('style', 'display:none');
                else{
                    $("#sizes").attr('style','display:block');
                    $("#sizes-list").attr('style','display:block');
                    for(var i = 0; i < data['sizes'].length; i++){
                        if (data['sizes'][i] != null)
                            document.getElementById('sizes-list').innerHTML += '<li class="addon-item"><input type="radio" name="sizes" onclick="checkToAdd(this,'+data['sizes'][i]['price']+')" class="check-addon" value="'+data['sizes'][i]['id']+'">'+checkMark+get_local_string(data['sizes'][i]['name_ar'], data['sizes'][i]['name_en']);
                    }
                }
                if (data['addons'].length == 0 || data['addons'] == null) $("#addons").attr('style', 'display:none');
                else {
                    $("#addons").attr('style', 'display:block');
                    for (var i = 0; i < data['addons'].length; i++) {
                        if (data['addons'][i] != null)
                            document.getElementById('addons-list').innerHTML += '<li class="addon-item"><input type="checkbox" onclick="checkToAdd(this,'+data['addons'][i]['price']+')" class="check-addon" name="addons" value="' + data['addons'][i]['id'] + '">'+checkMark + get_local_string(data['addons'][i]['name_ar'], data['addons'][i]['name_en']) + '</li>';

                    }
                }
                if (data['edits'].length == 0 || data['edits'] == null) $("#edits").attr('style', 'display:none');
                else {
                    $("#edits").attr('style', 'display:block');
                    for (var i = 0; i < data['edits'].length; i++) {
                        if (data['edits'][i] != null)
                            document.getElementById('edits-list').innerHTML += '<li class="addon-item"><input type="checkbox" class="check-addon" name="edits" value="' + data['edits'][i]['id'] + '"> ' +checkMark+ get_local_string(data['edits'][i]['name_ar'], data['edits'][i]['name_en']) + '</li>';

                    }
                }
                if (data['sauces'].length == 0) $("#sauces").attr('style', 'display:none');
                else {
                    $("#sauces").attr('style', 'display:block');
                    for (var i = 0; i < data['sauces'].length; i++) {
                        if (data['sauces'][i] != null)
                            document.getElementById('sauces-list').innerHTML += '<li class="addon-item"><input type="checkbox" class="check-addon" onclick="checkToAdd(this,'+data['sauces'][i]['price']+'" name="sauces" value="' + data['sauces'][i]['id'] + '"> '+checkMark + get_local_string(data['sauces'][i]['name_ar'], data['sauces'][i]['name_en']) + '</li>';

                    }
                }
                $("#loading").attr('style', 'display:none');
                $("#product-content").attr('style', 'display:flex');
                $("#qauntity").attr('style', 'display:block');
                $("#options").attr('style', 'display:block');
                $("#addons-list").attr('style', 'display:block');
                $("#edits-list").attr('style', 'display:block');
                $("#sauces-list").attr('style', 'display:block');
            }
        });
    }
    $(document).ready(function() {
        
        $("#error-close").click(function(){
            $("#errorMessage").removeClass('popup');
            $("#errorMessage").attr('style','z-index:-1;opacity:0');
        });
        $("#cart-form").submit(function(e) {
            e.preventDefault();
            document.getElementById('modal-close').click();
            var qty = $("#quantity").val();
            var product_id = $("#product_id").val();
            var store_id = $("#store_id").val();
            var addons = $("input:checkbox[name=addons]:checked").map(function() {
                return $(this).val();
            }).get();
            var edits = $("input:checkbox[name=edits]:checked").map(function() {
                return $(this).val();
            }).get();
            var sauces = $("input:checkbox[name=sauces]:checked").map(function() {
                return $(this).val();
            }).get();
            var sizes = $("input:radio[name=sizes]:checked").map(function() {
                return $(this).val();
            }).get();
            console.log(sizes);
            var formData = {
                'quantity': qty,
                'store_id': store_id,
                'product_id': product_id,
                'addons': addons,
                'edits': edits,
                'sauces': sauces,
                'sizes':sizes,
                _token: ' <?php echo csrf_token() ?>'
            };
            $.ajax({
                type: "POST",
                url: '{{url("add_to_cart")}}',
                data: formData,
                success: function(data) {
                    console.log(data);
                    document.getElementById('snackbar').innerHTML = data['message'];
                    var total = parseFloat($("#total_req").html());
                    var price = parseFloat($("#cart_price").html());
                    total += price;
                    $("#total_req").html(total);
                    //showToast();
                },
                error: function() {
                    document.getElementById('snackbar').innerHTML = "{{__('messages.unknown_error')}}";
                    showToast();
                }
            });
        });
    });
    function checkToAdd(checkbox,price){
        
        var total = parseFloat($("#product_price").val());
        var quantity = parseFloat($("#quantity").val());
        price = price * quantity;
        if(checkbox.checked){
            total += price;
            $("#product_price").val(total);
            add(price);
        }else{
        
            total -= price;
            $("#product_price").val(total);
            remove(price);
        }
    }
    function add(value){
        var total = parseFloat($("#cart_price").html());
        total += value;
        $("#cart_price").html(total);
    }
    function remove(value){
        var total = parseFloat($("#cart_price").html());
        total -= value;
        $("#cart_price").html(total);
    }

</script>
@endsection