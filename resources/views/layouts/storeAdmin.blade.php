<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href={{asset('assets/newcorkui/bootstrap/css/bootstrap.min.css')}} rel="stylesheet" type="text/css" />

    <link href={{asset('assets/newcorkui/css/plugins.css')}} rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @if(App::isLocale('ar'))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    @endif

    <script src={{asset("assets/newcorkui/plugins/select2/select2.min.js")}}></script>
    <script src={{asset("assets/newcorkui/plugins/select2/custom-select2.js")}}></script>
    <link href={{asset("assets/newcorkui/plugins/bootstrap-select/bootstrap-select.min.css")}} rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}"/>
    @if(App::isLocale('ar'))
    <link rel="stylesheet" href="{{asset('css/rtl.css')}}" />
    @endif
    @yield('css')
</head>

<body>
    <aside class="side">
        <ul class="side-nav">
            <li><a href="{{url('store/dashboard')}}"><i class="fa fa-home"></i> {{__('chef.dashboard')}}</a></li>
            <li><a href="{{url('store/inventory')}}"><i class="fa fa-boxes"></i> {{__('chef.inventory')}}</a></li>
            @if(auth()->user()->hasStoreRole('view_table') && plan_has_role('tables'))
            <li><a href="{{url('store/tables')}}"><i class="fa fa-utensils"></i> {{__('tables.tables')}}</a></li>
            <li><a href="{{url('store/waiter_call')}}"><i class="fa fa-coffee"></i> {{__('tables.waiter_call')}}</a></li>
            @endif

            @if(auth()->user()->hasStoreRole('view_order'))
            <li><a href="{{url('store/orders')}}"><i class="fa fa-money-bill"></i> {{__('orders.orders')}}</a></li>
            @endif
            @if(auth()->user()->hasStoreRole('view_branch') && plan_has_role('branches'))
            <li><a href="{{url('store/branches')}}"><i class="fa fa-store"></i> {{__('chef.branches')}}</a></li>
            @endif
            <li><a href="{{url('store/print_qr')}}"><i class="fa fa-qrcode"></i> {{__('chef.print_qr')}}</a></li>
            @if(auth()->user()->hasStoreRole('view_coupon'))
            <li><a href="{{url('store/coupons')}}"><i class="fa fa-percent"></i> {{__('chef.coupon')}}</a></li>
            @endif
            @if(auth()->user()->hasStoreRole('view_expense'))
            <li><a href="{{url('store/expenses')}}"><i class="fa fa-dollar-sign"></i> {{__('expenses.expenses')}}</a></li>
            @endif
            @if(auth()->user()->hasStoreRole('view_plan'))
            <li><a href="{{url('store/plans')}}"><i class="fa fa-bookmark"></i> {{__('chef.sub_plan')}}</a></li>
            @endif

            @if(auth()->user()->hasStoreRole('view_user'))
            <li><a href="{{url('store/users')}}"><i class="fa fa-user"></i> {{__('chef.store_admins')}}</a></li>
            @endif
            <li><a href="{{url('store/my_stores')}}"><i class="fa fa-store"></i> {{__('chef.my_stores')}}</a></li>
            <li><a href="{{url('store/settings')}}"><i class="fa fa-cog"></i> {{__('chef.settings')}}</a></li>
            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> {{__('chef.logout')}}</a></li>
        </ul>
    </aside>
    <div class="main">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">@if(isset($store))
                    @if(App::isLocale('ar')) {{$store->name_ar}} @else {{$store->name_en}} @endif
                    @else {{__('chef.dashboard')}} @endif</a>
                <select id="switch-lang">
                    <option value="ar" {{App::isLocale('ar')?'selected':''}}>العربية</option>
                    <option value="en" {{App::isLocale('en')?'selected':''}}>English</option>
                </select>

                <button id="side-btn" class="navbar-toggler" type="button" onclick="openDrawer();">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        @php $stores = get_user_stores(); @endphp
        @if($stores != null)
        <form class="container col-md-11" style="background-color: transparent;padding:0 15px" id="switch_store" action="{{url('store/switch')}}" method="POST">
            @csrf
            <select class="selectpicker form-control" name="store_id" onchange="event.preventDefault();document.getElementById('switch_store').submit();">
                @foreach($stores as $store)
                <option value="{{$store->store_id}}" {{$store->store_id == session('store_id')?'selected':''}}>{{App::isLocale('ar')?$store->store->name_ar:$store->store->name_en}}</option>
                @endforeach
            </select>
        </form>
        @endif
        @yield('content')
        
        <!-- The actual snackbar -->
        <div id="snackbar"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src={{asset("assets/newcorkui/bootstrap/js/popper.min.js")}}></script>
    <script src={{asset("assets/newcorkui/bootstrap/js/bootstrap.min.js")}}></script>
    <script src={{asset("assets/newcorkui/plugins/bootstrap-select/bootstrap-select.min.js")}}></script>
    <script>
        var i = 0;

        function openDrawer() {
            if (i == 0) {
                $(".side").attr('style', 'opacity:1;z-index:99999');
                $(".side").removeClass('slide-out');
                $(".side").addClass('slide-in');
                i = 1;
            } else {
                $(".side").attr('style', 'opacity:0;z-index:-1');
                $(".side").removeClass('slide-in');
                $(".side").addClass('slide-out');
                i = 0;
            }
        }

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
        $(document).ready(function() {
            $("#switch-lang").change(function(e) {
                window.location = '{{url("lang")}}/' + $("#switch-lang").val();
            });
        });
    </script>
    @yield('js')
</body>

</html>