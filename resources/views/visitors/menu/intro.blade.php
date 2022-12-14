<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant </title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    
    <link rel="stylesheet" type="text/css" href="{{asset('css/light.css')}}" />
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />

    @if(App::isLocale('en'))
    <link rel="stylesheet" type="text/css" href="{{asset('css/en.css')}}" />
    @endif
    @php $theme = get_theme(); @endphp
    <style>
    body{
        background-image: url('{{asset("image/intro-back.png")}}');
    }
    *{
        color: #000;
    }
        @media (min-width:768px){
           
        }
        .image{
            display: block;
            border-radius: 150px;
            height: 150px;
            width: 150px;
            margin: auto;
        }
        .btn{
            display: block;
            margin: auto;
        }
    .map{
        position: absolute;
        top: 0;
        z-index: -1;
        opacity: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 25px 35px;
    }
    .map div{
        position: relative;
        margin: auto;
        padding: 0;
        border-radius: 10px;
        width: 100%;
    }
    .map div #close,#work_days #days_close{
        position: absolute;
        background-color: #fcc02c;
        height: 25px;
        width: 25px;
        text-align: center;
        border: 1px solid #000;
        border-radius: 150px;
        top: 0;
        right: 0;
        z-index: 99999;
    }
    .map div .open-google{
        position: absolute;
        bottom: 10px;
        padding: 10px 30px;
        text-align: center;
        background-color: #fcc02c;
        color: #000;
        border-radius: 35px;
        right: 0;
        left: 0;
        margin: 0 30px;
    }
    #work_days #days_close{
        top: 0;
        right: 50px;
    }
    .map iframe{
        width: 100%;
        height: 100%;
    }
    .input{
        background-color: transparent;
        border: none;
        display: block;
        padding: 0;
        text-align: center;
        width: 100%;
        font-weight: bold;
    }
    #work_days{
        position: absolute;
        top: 50px;
        z-index: -1;
        opacity: 0;
        display: flex;
        padding: 10px 35px;
        width: 100%;
    }
    #work_days div{
        border-radius: 10px;
        padding: 20px 30px;
        background-color: #fff;
        color: #000;
        margin: auto;
    }
    #work_days p{
        text-align: center;
    }
    
    </style>
    @if($theme != null)
    <style>
        body{
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}} @endif
            
        }

        .information,.info-product,#work_days div{
            @if($theme->font_color != null) {{'color:'.$theme->font_color.' !important;'}} @endif
            @if($theme->information_class_background != null) {{'background-color:'.$theme->information_class_background.' !important;'}} @endif
            
        }
        .list-style .information .info-content, .grid-style .information .info-content{
            @if($theme->information_class_color != null) {{'color:'.$theme->information_class_color.';'}} @endif
        }
        .title-section h1,.additions h1{
            @if($theme->primary_color != null) {{'background:'.$theme->primary_color.';'}} @endif
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}}@endif
        }
        #myCarousel1 .tab.active{
            
            @if($theme->primary_color != null) {{'background:'.$theme->primary_color.';'}} @endif
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}}@endif
        }
        #myCarousel1 .item,
        .select2-container--default .select2-selection--single, #dropdownMenuButton,.quantity .fa{
            @if($theme->primary_color != null) {{'color:'.$theme->primary_color.';'}} @endif
            @if($theme->primary_color != null) {{'border:1px solid '.$theme->primary_color.' !important;'}} @endif
        }
        .current,a{
            @if($theme->font_color != null) {{'color:'.$theme->font_color.' !important;'}} @endif
        }
        .list-style .information .info-pric p, .grid-style .information .info-pric p,.cart .info-product .pric{
            @if($theme->price_back_color != null) {{'background:'.$theme->price_back_color.' !important;'}} @endif
            @if($theme->price_back_color != null) {{'border:1px solid '.$theme->price_back_color.' !important;'}} @endif
            @if($theme->price_back_color != null) {{'box-shadow:0px 4px 5px 0px '.$theme->price_back_color.' !important;'}} @endif
        }
        .modal-body .close{
            @if($theme->primary_color != null) {{'background:'.$theme->primary_color.';'}}@endif
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}}@endif
        }
        .btn:hover,.quantity .fa:hover,.btn-cart:hover,#myCarousel1 .item:hover{
            @if($theme->secondary_color != null) {{'background:'.$theme->secondary_color.' !important;'}}@endif
        }
        .cart .btn-checkout:hover{
            @if($theme->secondary_color != null) {{'background:'.$theme->secondary_color.' !important;'}}@endif
            @if($theme->primary_color != null) {{'box-shadow:0px 4px 5px 0px '.$theme->primary_color.' !important;'}} @endif
        }
        .quantity input,.cart .info-product h3{
            @if($theme->primary_color != null) {{'color:'.$theme->primary_color.';'}}@endif
        }
        .btn-cart,.cart .btn-group button,.cart .btn-checkout, .cart .btn-back{
            @if($theme->primary_color != null) {{'background:'.$theme->primary_color.';'}} @endif
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}}@endif
            @if($theme->primary_color != null) {{'border:1px solid '.$theme->primary_color.' !important;'}} @endif
        }
        
    </style>
    @endif
    @yield('css')
</head>

<body @if($theme != null && $theme->intro_image != null) style="background-image:url('{{asset("storage/".$theme->intro_image)}}')" @endif>

    <!--head section-->
    <div class="head-section">
        <div class="container-fluid" style="padding: 0px 25px;">
                <div class="row">
                <div class="col-6 text-left" style="font-size: 25px;">
                @if($store->maps_url != null)
                <a href="#" id="openMap" style="padding: 0px 10px;"><i class="fa fa-map-marker-alt"></i></a>
                @endif
                </div>
                <div class="col-6 text-right" style="font-size: 25px;">
                @if(App::isLocale('ar'))
                <a href="{{url('lang/en')}}" style="padding: 0px 10px;"><i class="fa fa-globe"></i> EN</a>
                @else
                <a href="{{url('lang/ar')}}" style="padding: 0px 10px;"><i class="fa fa-globe"></i> AR</a>
                @endif
                </div>
                </div>
        </div></div>
    <!-- end head section-->

<div class="container" style="margin-top: 50px;">
        <div class="container">
            <img class="image" src="{{$store->logo==null?asset('storage/stores/shops.png'):asset('storage'.$store->logo)}}"></div>
           
        
            <div class="container" style="padding: 15px 0px;">
            <a type="button" href="{{session('table')==null?url('store/menu',$store->id):url('menu')}}" class="btn btn-cart shadow" style="width: 150px;">{{__('menu.menu')}}</a>
            </div>
            <div class="text-center" style="font-size:40px">
                @if($store->facebook != null) <a href="{{$store->facebook}}" style="padding: 0px 5px;" target="_blank"><i class="fab fa-facebook-square"></i></a> @endif
                @if($store->instagram != null) <a href="{{$store->instagram}}" style="padding: 0px 5px;" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                @if($store->twitter != null) <a href="{{$store->twitter}}" style="padding: 0px 5px;" target="_blank"><i class="fab fa-twitter"></i></a> @endif
                @if($store->whatsapp != null) <a href="{{$store->whatsapp}}" style="padding: 0px 5px;" target="_blank"><i class="fab fa-whatsapp"></i></a> @endif
                @if($store->telegram != null) <a href="{{$store->telegram}}" style="padding: 0px 5px;" target="_blank"><i class="fab fa-telegram"></i></a> @endif
            </div>
            
            <div class="container" style="padding: 15px 0px;text-align: center;">
            <a type="button" class="work_days_btn shadow" id="work_days_btn">{{__('days.week_days')}}</a>
            </div>
        </div>
    <!-- The actual snackbar -->
    <div id="work_days"><div>
    <button id="days_close">X</button>
    @if(count($work_days) > 0)
    <p>{{__('days.saturday').': '}}@if($work_days[0]->is_off == 0){{get_time_string($work_days[0]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[0]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.sunday').': '}}@if($work_days[1]->is_off == 0){{get_time_string($work_days[1]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[1]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.monday').': '}}@if($work_days[2]->is_off == 0){{get_time_string($work_days[2]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[2]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.tuesday').': '}}@if($work_days[3]->is_off == 0){{get_time_string($work_days[3]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[3]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.wednesday').': '}}@if($work_days[4]->is_off == 0){{get_time_string($work_days[4]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[4]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.thursday').': '}}@if($work_days[5]->is_off == 0){{get_time_string($work_days[5]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[5]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    <p>{{__('days.friday').': '}}@if($work_days[6]->is_off == 0){{get_time_string($work_days[6]->opening_time).' '.__('menu.to').' '.get_time_string($work_days[6]->closing_time)}} @else {{__('menu.closed')}} @endif</p>
    @if($store->work_days_note != null)<p>{{$store->work_days_note}}</p>@endif
    @endif
    </div></div>
    @if($store->latitude != null && $store->longtude)
    <div class="map" id="map-container">
    <div>
    <button id="close">X</button>
    <div id="map"></div>
    <a type="button" class="open-google" href="https://maps.google.com/maps?q={{$store->latitude.','.$store->longtude}}" target="__blank">{{__('chef.open_in_google_maps')}}</a>
    <div>
    </div>
    @endif
    <!--script section-->
    @include('visitors.scripts.map')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).on('click', '.btn-show', function() {
            var show = $(this).data('show');
            $(show).removeClass("hide").siblings().addClass("hide");
        });
    </script>
    <script>

        $(document).ready(function() {
            var latlng = {
                'lat':parseFloat({{$store->latitude}}),
                'lng':parseFloat({{$store->longtude}})
            };
            addMarker(latlng);
            $('.btn-group button ').click(function() {
                $(' button ').removeClass("current");
                $(this).addClass("current");
            });
            $('#openMap').click(function(){
                $("#map-container").attr('style','opacity:1;z-index:9999');
                $("#map-container").addClass('popup');
            });
            $('#work_days_btn').click(function(){
                $("#work_days").attr('style','opacity:1;z-index:9999');
                $("#work_days").addClass('popup');
            });
            $("#close").click(function(){
                $("#map-container").attr('style','opacity:0;z-index:-1');
                $("#map-container").removeClass('popup');
            });
            $("#days_close").click(function(){
                $("#work_days").attr('style','opacity:0;z-index:-1');
                $("#work_days").removeClass('popup');
            });
        });

        function showToast() {
            // Get the snackbar DIV
            var x = document.getElementById("snackbar");

            // Add the "show" class to DIV
            x.className = "show";

            // After 3 seconds, remove the show class from DIV
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }

    </script>
    @yield('js')
</body>

</html>