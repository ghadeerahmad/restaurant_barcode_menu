@extends('layouts.storeAdmin')
@section('title',__('plans.confirm_payment'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <h3>{{__('plans.confirm_payment')}}</h3>
        @if(isset($paypal) && $paypal->value == 1)
        <div class="row">
            <div class="col-md-5">
                <form action="{{url('store/plans/confirm_payment',$plan->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                    <input type="hidden" name="branche_count" value="{{$branche_count}}">
                    <div class="mb-3">
                        <label class="form-label">{{__('plans.choose_payment')}}</label>
                        <select class="selectpicker form-control" name="method_id" id="method">
                            <option>-{{__('plans.choose_payment')}}-</option>
                            @foreach($payment_methods as $value)
                            <option value="{{$value->id}}">{{App::isLocale('ar')?$value->title_ar:$value->title_en}}</option>
                            @endforeach
                        </select>
                        <div class="container" id="method_info" style="display: none;">
                            <p id="des" style="display: none;"></p>
                            <p><img id="img" style="display: none;"></p>
                            <div class="mb-3"><input type="text" disabled id="account_number" class="form-control" style="display: none;"></div>
                        </div>
                        <div class="container" id="payment-form" style="display: none;">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input type="text" name="payment_number" class="form-control" id="floatingInput" placeholder="{{__('plans.payment_number')}}">
                                    <label for="floatingInput">{{__('plans.payment_number')}}</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{__('plans.payment_image')}}</label>
                                <img src="" style="display: none;" width="100%" id="preview">
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary">{{__('plans.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2" style="display: flex;justify-content: center;margin:auto">
                <h2>{{__('plans.or')}}</h2>
            </div>
            <div class="col-md-5">
                <p>{{$plan->price.$plan->currency->code}}</p>
                <a type="button" class="btn btn-success" href="{{url('store/plans/paypal_payment',$plan->id)}}">{{__('plans.checkout')}}</a>
            </div>
        </div>
        @else
        <form action="{{url('store/plans/confirm_payment',$plan->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
            <div class="mb-3">
                <label class="form-label">{{__('plans.choose_payment')}}</label>
                <select class="selectpicker form-control" name="method_id" id="method">
                    <option>-{{__('plans.choose_payment')}}-</option>
                    @foreach($payment_methods as $value)
                    <option value="{{$value->id}}">{{App::isLocale('ar')?$value->title_ar:$value->title_en}}</option>
                    @endforeach
                </select>
                <div class="container" id="method_info" style="display: none;">
                    <p id="des" style="display: none;"></p>
                    <p><img id="img" style="display: none;"></p>
                    <div class="mb-3"><input type="text" disabled id="account_number" class="form-control" style="display: none;"></div>
                </div>
                <div class="container" id="payment-form" style="display: none;">
                    <div class="mb-3">
                        <div class="form-floating mb-3">
                            <input type="text" name="payment_number" class="form-control" id="floatingInput" placeholder="{{__('plans.payment_number')}}">
                            <label for="floatingInput">{{__('plans.payment_number')}}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('plans.payment_image')}}</label>
                        <img src="" style="display: none;" width="100%" id="preview">
                        <input type="file" class="form-control" name="image" id="image">
                    </div>

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" class="btn btn-primary">{{__('plans.submit')}}</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</section>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $("#method").change(function(e) {
            var id = $("#method").val();
            var locale = '{{App::isLocale("ar")?"ar":"en"}}';
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '{{url("store/plans/method_details/")}}/' + id,
                success: function(data) {
                    if (data != null) {
                        $("#payment-form").attr('style', 'display:block');
                        console.log(data);
                        $("#method_info").attr('style', 'display:block');
                        if (data['description_' + locale] != null) {
                            $("#des").attr('style', 'display:block');
                            document.getElementById('des').innerHTML = data['description_' + locale];
                        }
                        if (data['account_number'] != null) {
                            $("#account_number").attr('style', 'display:block');
                            $("#account_number").attr('value', data['account_number']);
                        }
                        if (data['image'] != null) {
                            $("#img").attr('style', 'display:block');
                            $("#img").attr('src', data['image']);
                        }
                    }
                }
            });
        });
    });
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $("#preview").attr('style', 'display:block');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function() {
        readURL(this);
    });
</script>
@endsection