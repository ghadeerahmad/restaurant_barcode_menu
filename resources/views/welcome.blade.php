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
    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">
        <div id="first" class="first-section">
            <div class="container-fluid gradient-cover text-center">
                <div class="flex">
                    <h1>LOGO</h1>
                    <p class="section-title">{{__('home.new_gen')}}</p>
                    <p class="section-title">{{__('home.whats_order')}}</p>
                </div>
            </div>
        </div>
        <div class="container text-center" style="position:relative" id="second">
            <div style="position: relative;margin-bottom: 100px;" data-aos="fade-up">

                <p class="behind">{{__('home.why')}}</p1>
                <p class="front">{{__('home.no_need_to_paper')}}</p>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #d8d6ff;">
                            <img src="{{asset('home/images/mobile-phone.1e339ff6.1e339ff6.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.cool_layout')}}</h3>
                        <p3 class="para3">{{__('home.cool_layout_des')}}</p3>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #ffefd4">
                            <img src="{{asset('home/images/offers.53478e6b.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.latest_sales')}}</h3>
                        <p>{{__('home.latest_sales_des')}}</p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #ffefd4">
                            <img src="{{asset('home/images/menu-2.a69bd6a1.a69bd6a1.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.instant_refresh')}}</h3>
                        <p3 class="para3">{{__('home.instant_refresh_des')}}</p3>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #ffefd4">
                            <img src="{{asset('home/images/Support.ea5a6398.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.support')}}</h3>
                        <p3 class="para3">{{__('home.support_des')}}</p3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #ffefd4">
                            <img src="{{asset('home/images/iconfinder-icon.a3c1ddd7.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.many_sections')}}</h3>
                        <p3 class="para3">{{__('home.many_sections_des')}}</p3>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6" style="margin-bottom: 100px;">
                    <div class="container why-item">
                        <div class="circle-image" style="background-color: #ffefd4">
                            <img src="{{asset('home/images/qrcode-icon.c48e1945.svg')}}" alt="menu-2" />
                        </div>
                        <h3>{{__('home.QR_code')}}</h3>
                        <p3 class="para3">{{__('home.QR_code_des')}}</p3>

                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="third">
            <h1 class="text-center" data-aos="fade-up">{{__('home.choose_plan')}}</h1>
            <div class="row" data-aos="fade-up" style="display: flex;">
                @foreach($plans as $value)
                <div class="col-lg-4 col-md-6" style="height: 400px;flex-direction: row;margin-top:10px">
                    <div class="container plan">
                        <h1 class="text-center">{{get_local_name($value->name_ar,$value->name_en)}}</h1>
                        <h6 class="text-center">{{__('home.price')}} : {{$value->price.' '.$currency->code}}</h6>
                        <br>
                        @if(App::isLocale('ar'))
                        {!! $value->description_ar !!}
                        @else
                        {!! $value->description_en !!}
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="container" id="fourth" style="margin-top: 50px;">
            <div class="container contact" style="border-radius: 20px;padding:0;overflow:hidden">
                <div data-aos="fade-up" class="row">
                    <div class="col-md-7">
                        <img class="ph" src="{{asset('home/images/img3.jpg')}}" alt="photo" width="100%" />
                    </div>
                    <div class="col-md-5" style="padding: 20px 20px;">
                        <h4 style="padding-bottom: 30px;"><strong>{{__('home.still_undecided')}}</strong></h4>
                        <p>{{__('home.contact_us')}}</p>
                        <input x-model="dataForm.name.value" type="text" placeholder="{{__('home.name')}}" class="w-full px-2 py-3 mt-4 text-black border rounded  border-brand-3 focus:outline-none focus:ring-1 focus:ring-brand-3" oninvalid="this.setCustomValidity('الرجاء تعبئة حقل الاسم')" />
                        <input x-model="dataForm.name.value" type="text" placeholder="{{__('home.phone')}}" class="w-full px-2 py-3 mt-4 text-black border rounded  border-brand-3 focus:outline-none focus:ring-1 focus:ring-brand-3" oninvalid="this.setCustomValidity('الرجاء تعبئة حقل الاسم')" />
                        <button type="submit" class="w-full btn p-3 mt-5"><span>{{__('home.send')}}</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container text-center" id="fifth" style="margin-top: 50px;">
            <div style="position: relative;margin-bottom: 100px;" data-aos="fade-up">

                <p class="behind">{{__('home.statistics')}}</p1>
                <p class="front">{{__('home.our_numbers')}}</p>
            </div>
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-md-4 trap text-center dark:text-black">
                    <h2 class="text-5xl md:text-3xl lg:text-5xl font-bold mb-4" style="font-size: 50px;font-weight: bold;"><span class="counter" data-target="10000">0</span>+</h2>
                    <p class="text car">{{__('home.whatsapp_dial_monthly')}}</p>
                </div>
                <div class="col-md-4 trap text-center dark:text-black">
                    <h2 class="text-5xl md:text-3xl lg:text-5xl font-bold mb-4" style="font-size: 50px;font-weight: bold;"><span class="counter" data-target="8000">0</span>+</h2>
                    <p class="text car">{{__('home.daily_view')}}</p>
                </div>
                <div class="col-md-4 trap text-center dark:text-black">
                    <h2 class="text-5xl md:text-3xl lg:text-5xl font-bold mb-4" style="font-size: 50px;font-weight: bold;"><span class="counter" data-target="3000">0</span>+</h2>
                    <p class="text car">{{__('home.money_saved_yearly')}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- footer section -->
    <footer class="container-fluid text-center" style="margin-top: 50px;">
        <p>{{__('home.rights_reserved')}}</p>
        <ul class="footer-menu">
            <li><a href="privacy">{{__('home.privacy')}}</a></li>
            <li><a href="terms">{{__('home.terms')}}</a></li>
        </ul>
    </footer>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script> <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const counters = document.querySelectorAll('.counter');
        const speed = 200;
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerHTML;
                const inc = target / speed;
                if (count < target) {
                    counter.innerHTML = count + inc;
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerHTML = target;
                }
            }
            updateCount();
        });
    </script>
</body>

</html>