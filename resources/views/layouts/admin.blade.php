<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href={{asset('assets/newcorkui/bootstrap/css/bootstrap.min.css')}} rel="stylesheet" type="text/css" />

    <link href={{asset('assets/newcorkui/css/plugins.css')}} rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous"> -->

    <script src={{asset("assets/newcorkui/plugins/select2/select2.min.js")}}></script>
    <script src={{asset("assets/newcorkui/plugins/select2/custom-select2.js")}}></script>
    <link href={{asset("assets/newcorkui/plugins/bootstrap-select/bootstrap-select.min.css")}} rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    @if(App::isLocale('ar'))
    <link rel="stylesheet" href="{{asset('css/rtl.css')}}" />
    @endif
    @yield('css')
</head>

<body>
    <aside class="side">
        <ul class="side-nav">
            <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i> {{__('admin.dashboard')}}</a></li>
            <li><a href="{{url('admin/new-stores')}}"><i class="fa fa-home"></i> {{__('chef.stores')}}</a></li>
            @if(auth()->user()->hasSiteRole('update_plan'))
            <li><a href="{{url('admin/plans')}}"><i class="fa fa-hand-holding-usd"></i> {{__('admin.store_plans')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('view_plan_order'))
            <li><a href="{{url('admin/plans/orders')}}"><i class="fa fa-hand-holding-usd"></i> {{__('admin.plans_orders')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('view_store_privilege'))
            <li><a href="{{url('admin/stores/privileges')}}"><i class="fa fa-user-tag"></i> {{__('admin.store_privileges')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('view_site_privilege'))
            <li><a href="{{url('admin/site_privileges')}}"><i class="fa fa-user-tag"></i> {{__('admin.site_privileges')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('view_question'))
            <li><a href="{{url('admin/questions')}}"><i class="fas fa-chalkboard-teacher"></i> {{__('admin.instructions')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('view_admin'))
            <li><a href="{{route('admin.admins')}}"><i class="fa fa-user-shield"></i> {{__('users.admins')}}</a></li>
            @endif

            @if(auth()->user()->hasSiteRole('view_theme'))
            <li><a href="{{route('admin.themes')}}"><i class="fa fa-palette"></i> {{__('themes.themes')}}</a></li>
            @endif
            @if(auth()->user()->hasSiteRole('update_settings'))
            <li><a href="{{route('admin.settings')}}"><i class="fas fa-cog"></i> {{__('settings.settings')}}</a></li>
            <li><a href="{{url('admin/privacy_terms')}}"><i class="fas fa-cog"></i> {{__('settings.privacy_terms')}}</a>
            @endif
            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out-alt"></i> {{__('chef.logout')}}</a></li>
        </ul>
    </aside>
    <div class="main">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"> {{__('admin.dashboard')}} </a>
                <select id="switch-lang">
                    <option value="ar" {{App::isLocale('ar')?'selected':''}}>العربية</option>
                    <option value="en" {{App::isLocale('en')?'selected':''}}>English</option>
                </select>
                <button id="side-btn" class="navbar-toggler" type="button" onclick="openDrawer();">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
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