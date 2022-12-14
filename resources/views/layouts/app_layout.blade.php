<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant </title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css" integrity="sha512-72McA95q/YhjwmWFMGe8RI3aZIMCTJWPBbV8iQY3jy1z9+bi6+jHnERuNrDPo/WGYEzzNs4WdHNyyEr/yXJ9pA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    @if($theme != null)
    <style>
        body{
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}} @endif
        }
        .information,.info-product{
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
        .current,a,#myCarousel1 .item h1{
            @if($theme->primary_color != null) {{'color:'.$theme->primary_color.' !important;'}} @endif
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
            @if($theme->font_color != null) {{'color:'.$theme->font_color.';'}}@endif
        }
        .btn-cart,.cart .btn-group button,.cart .btn-checkout, .cart .btn-back,.floating-btn{
            @if($theme->primary_color != null) {{'background:'.$theme->primary_color.' !important;'}} @endif
            @if($theme->font_color != null) {{'color:'.$theme->font_color.' !important;'}}@endif
            @if($theme->primary_color != null) {{'border:1px solid '.$theme->primary_color.' !important;'}} @endif
        }
        
    </style>
    @endif
    <style>
        .col-md-10{
            padding: 0;
        }
        @media (min-width:768px){
            .col-md-10{
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>
    @yield('css')
</head>

<body @if($theme != null && $theme->background_image != null) style="background-image:url('{{asset("storage/".$theme->background_image)}}')" @endif>

    <!--head section-->
    <div class="head-section">
        <div class="container-fluid">
            <div class="row" style="align-items: center;">

                <div class="col-7 logo">
                @if(isset($store) && $store != null)
                    <a href="#">
                        <img src="@if($store->logo != null){{asset('storage'.$store->logo)}}@else{{asset('storage/stores/shops.png')}}@endif" style="width: 75px;height:75px">
                    </a>
                @endif
                </div>
                <div class="col-2">
                
                </div>
                
                <div class="col-3" style="font-size: 25px;">
                @if(App::isLocale('ar'))
                <a href="{{url('lang/en')}}"><i class="fa fa-globe"></i> EN</a>
                @else
                <a href="{{url('lang/ar')}}"><i class="fa fa-globe"></i> AR</a>
                @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- end head section-->
    @yield('content')

    <!-- The actual snackbar -->
    <div id="snackbar"></div>
   
    <!--script section-->
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
            $('.btn-group button ').click(function() {
                $(' button ').removeClass("current");
                $(this).addClass("current");
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
    <script>
        var minVal = 1,
            maxVal = 100;
        $(".increaseQty").on('click', function() {
            var $parentElm = $(this).parents(".quantity");
            $(this).addClass("clicked");
            setTimeout(function() {
                $(".clicked").removeClass("clicked");
            }, 100);
            var value = $parentElm.find(".qtyValue").val();
            if (value < maxVal) {
                value++;
            }
            $parentElm.find(".qtyValue").val(value);
            var total = parseFloat($("#product_price").val());
            
            add(total);
        });

        $(".decreaseQty").on('click', function() {
            var $parentElm = $(this).parents(".quantity");
            $(this).addClass("clicked");
            setTimeout(function() {
                $(".clicked").removeClass("clicked");
            }, 100);
            var value = $parentElm.find(".qtyValue").val();
            if (value > 1) {
                value--;
            var total = parseFloat($("#product_price").val());
            remove(total);
            }
            $parentElm.find(".qtyValue").val(value);
        });
    </script>
    <script>
        var local = '{{App::isLocale("ar")?"ar":"en"}}';
        $('#myCarousel1').owlCarousel({
            interval: 0,
            loop: false,
            margin: 10,
            nav: true,
            animateOut: 'fadeOut',
            autoplay: false,
            navText: ['<a ><i class="fa fa-arrow-left" aria-hidden="true"></i></a>', '<a ><i class="fa fa-arrow-right" aria-hidden="true"></i></a>'],
            autoplayTimeout: 8000,
            rtl: local == 'ar' ? true : false,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 5
                }

            }
        });
    </script>
    <script>
        $('.targetDiv').hide();
        $('.targetDiv').first().show();
        $('.showSingle').click(function() {
            $('.targetDiv').hide();
            $('.showSingle').removeClass('selected');
            $('#tab' + $(this).attr('target')).show();
            $(this).addClass('selected');
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".tab").click(function() {
                $(".tab").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
    <script>
        $(".js-example-placeholder-single").select2({
            placeholder: "Select Theme",
            allowClear: true
        });
    </script>
    @yield('js')
</body>

</html>