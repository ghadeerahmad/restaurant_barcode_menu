<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href={{url('store/dashboard')}}  aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>{{ __('chef.dashboard') }}</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href={{route('store.inventory')}}  aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <span>{{ __('chef.inventory') }}</span>
                    </div>
                </a>
            </li>
        </ul>
{{--        <div class="shadow-bottom"></div>--}}

    </nav>

</div>
