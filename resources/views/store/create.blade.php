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
    @yield('css')
</head>

<body>
<div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"> {{__('chef.create_store')}}</a>
                <button id="side-btn" class="navbar-toggler" type="button" onclick="openDrawer();">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    <div class="container col-md-11 shadow-lg">
        <div class="form-container">
            <div class="form-form container">
                <div class="form-form-wrap" style="width: 100%;">
                    <div class="form-container">
                        <div class="form-content">
                            <form class="text-left" method="POST" action="{{ url('store/create') }}">
                                @csrf
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @error('errors')
                                <div class="alert alert-warning d-flex align-items-center alert-dismissible" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        {{$message}}
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @if(session()->has('success'))
                                <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        {{session()->get('success')}}
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <div class="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input id="store_name" type="text" placeholder="{{__('auth.store_name_ar')}}" class="form-control" name="name_ar" value="{{ old('name_ar') }}" autocomplete="name">
                                                @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input id="name_en" type="text" placeholder="{{__('auth.store_name_en')}}" class="form-control" name="name_en" value="{{ old('name_en') }}" autocomplete="name">
                                                @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <textarea id="description" placeholder="{{__('auth.store_des_ar')}}" class="form-control" name="description_ar" autocomplete="description">{{old('description_ar')}}</textarea>
                                                @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <textarea id="description_en" placeholder="{{__('auth.store_des_en')}}" class="form-control" name="description_en" autocomplete="description">{{old('description_en')}}</textarea>
                                                @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{__('chef.currency')}}</label>
                                                <select class="selectpicker form-control" name="currency_id">
                                                    @foreach($currencies as $currency)
                                                    <option value="{{$currency->id}}">{{$currency->name}} - {{$currency->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{__('chef.store_lang')}}</label>
                                            <select class="selectpicker form-control" name="lang_code">
                                                <option>{{__('chef.both_lang')}}</option>
                                                <option value="ar">العربية</option>
                                                <option value="en">English</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-sm-flex justify-content-between">

                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <button type="submit" class="btn btn-primary" value="">{{__('chef.create')}}</button>
                                            </div>

                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
    </script>
    @yield('js')
</body>

</html>