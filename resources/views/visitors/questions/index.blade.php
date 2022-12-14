<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="{{asset('home/style.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.css')}}">
    @if($theme == 'dark')
    <link href="{{asset('home/styleDark.css')}}" rel="stylesheet" />
    @endif
    @if(App::getLocale() == 'ar')
    <link href="{{asset('home/rtl.css')}}" rel="stylesheet" />
    @endif
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <div style="display: flex;">
            @if($theme == 'dark')
            <a href="{{url('changeTheme/light')}}" class="nav-link show-mobile" style="margin:0 10px"><i class="fas fa-sun"></i></a>
            @else
            <a href="{{url('changeTheme/dark')}}" class="nav-link show-mobile" style="margin:0 10px"><i class="fas fa-moon"></i></a>
            @endif
            <button class="navbar-toggler" onclick="" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-center" style="width: 90%;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#first">{{__('home.home')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#second">{{__('home.why')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#third">{{__('home.pricing')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#fifth">{{__('home.our_numbers')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fourth">{{__('home.contact')}}</a>
                    </li>

                    <li class="nav-item"><a href="instructions" class="nav-link">{{__('home.instructions')}}</a></li>
                </ul>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item">
                        @if(App::getLocale() == 'en')
                        <a href="{{url('lang/ar')}}" class="nav-link">AR</a>
                        @else
                        <a href="{{url('lang/en')}}" class="nav-link">EN</a>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if($theme == 'dark')
                        <a href="{{url('changeTheme/light')}}" class="nav-link"><i class="fas fa-sun"></i></a>
                        @else
                        <a href="{{url('changeTheme/dark')}}" class="nav-link"><i class="fas fa-moon"></i></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container shadow-lg" style="padding: 35px 25px;margin-top:100px">
        <div class="accordion" id="accordionExample">
            @foreach($questions as $value)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne-{{$value->id}}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$value->id}}" aria-expanded="true" aria-controls="collapseOne">
                        {{get_local_name($value->question_ar,$value->question_en)}}
                    </button>
                </h2>
                <div id="collapseOne-{{$value->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne-{{$value->id}}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @if(App::isLocale('ar'))
                        {!! $value->answer_ar !!}
                        @else
                        {!! $value->answer_en !!}
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </script> <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
</body></html>