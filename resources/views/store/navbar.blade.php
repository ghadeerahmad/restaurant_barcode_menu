<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            {{--            <li class="nav-item theme-logo">--}}
            {{--                <a href="index.html">--}}
            {{--                    <img src={{asset("assets/newcorkui/img/90x90.jpg")}} class="navbar-logo" alt="logo">--}}
            {{--                </a>--}}
            {{--            </li>--}}
            <li class="nav-item theme-text">
                <a href="{{url('store_admin.dashboard')}}" class="nav-link">{{ Auth::user()->store_name }}</a>
            </li>
        </ul>

{{--        <ul class="navbar-item flex-row ml-md-0 ml-auto">--}}
{{--            <li class="nav-item align-self-center search-animated">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>--}}
{{--                <form class="form-inline search-full form-inline search" role="search">--}}
{{--                    <div class="search-bar">--}}
{{--                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </li>--}}
{{--        </ul>--}}

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">

                <form method="post" action="{{url("change_language")}}">
                    @csrf
                    <select class="nav-link dropdown-toggle" name="selected_language" data-width="fit" onchange="this.form.submit()">
                        <div class="dropdown-menu position-absolute">
                            
                        </div>
                    </select>
                </form>

{{--                <a href="#" class="nav-link dropdown-toggle" id="language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                    <img src={{asset("assets/newcorkui/img/ca.png")}} class="flag-width" alt="flag">--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">--}}
{{--                    <a class="dropdown-item d-flex" href="#"><img src={{asset("assets/newcorkui/img/de.png")}} class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;German</span></a>--}}
{{--                    <a class="dropdown-item d-flex" href="#"><img src={{asset("assets/newcorkui/img/jp.png")}} class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;Japanese</span></a>--}}
{{--                    <a class="dropdown-item d-flex" href="#"><img src={{asset("assets/newcorkui/img/fr.png")}} class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;French</span></a>--}}
{{--                    <a class="dropdown-item d-flex" href="#"><img src={{asset("assets/newcorkui/img/ca.png")}} class="flag-width" alt="flag"> <span class="align-self-center">&nbsp;English</span></a>--}}
{{--                </div>--}}
            </li>

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src={{asset("assets/images/avatar/1.jpg")}} alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>

                        <a href="{{url('logout')}}" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </li>

        </ul>
    </header>
</div>


<!-- Dashboard Navbar -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            {{--                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>--}}
                            <li class="breadcrumb-item active" aria-current="page"><span></span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
    </header>
</div>
