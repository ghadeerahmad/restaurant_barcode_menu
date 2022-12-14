<div class="container">
    <form action="{{url('store/update_info')}}" method="POST">
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
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">{{__('chef.store_logo')}}</label>
                <input type="hidden" id="logo" name="logo" value="{{$store->logo}}">
                <div class="image_area">

                    <label for="upload_image">
                        <img src="@if($store->logo != null) {{ asset('storage'.$store->logo) }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" width="100" height="100" />

                        <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                    </label>

                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name_ar" value="{{$store->name_ar}}" placeholder="{{__('chef.store_name_ar')}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name_en" value="{{$store->name_en}}" placeholder="{{__('chef.store_name_en')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <textarea class="form-control" placeholder="{{__('chef.store_description_ar')}}" name="description_ar">{{$store->description_ar}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <textarea class="form-control" placeholder="{{__('chef.store_description_en')}}" name="description_en">{{$store->description_en}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.currency')}}</label>
                    <select class="selectpicker form-control" name="currency_id">
                        @foreach($currencies as $c)
                        <option value="{{$c->id}}" {{$store->currency_id == $c->id?'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.store_lang')}}</label>
                    <select class="selectpicker form-control" name="lang_code">
                        <option>{{__('chef.both_lang')}}</option>
                        <option value="ar" {{$store->lang_code == 'ar'?'selected':''}}>العربية</option>
                        <option value="en" {{$store->lang_code == 'en'?'selected':''}}>English</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.address_ar')}}</label>
                    <textarea class="form-control" name="address_ar">{{$store->address_ar}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.address_en')}}</label>
                    <textarea class="form-control" name="address_en">{{$store->address_en}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time" value="{{$store->opening_time}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time" value="{{$store->closing_time}}">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.facebook')}}</label>
                    <input type="text" class="form-control" name="facebook" value="{{$store->facebook}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.instagram')}}</label>
                    <input type="text" class="form-control" name="instagram" value="{{$store->instagram}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.whatsapp')}}</label>
                    <input type="text" class="form-control" name="whatsapp" value="{{$store->whatsapp}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.twitter')}}</label>
                    <input type="text" class="form-control" name="twitter" value="{{$store->twitter}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('chef.telegram')}}</label>
                    <input type="text" class="form-control" name="telegram" value="{{$store->telegram}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="mb-3">
                    <label class="form-label">{{__('chef.work_days_note')}}</label>
                    <input type="text" class="form-control" name="work_days_note" value="{{$store->work_days_note}}">
                </div>
            </div>
            <div class="col-md-6">
            <div class="mb-3">
                    <label class="form-label">{{__('chef.tax_note')}}</label>
                    <input type="text" class="form-control" name="tax_note" value="{{$store->tax_note==null?__('chef.tax_note_value'):$store->tax_note}}">
                </div>
            </div>
        </div>
       <div class="row">
           <div class="col-md-2">
               <select class="selectpicker form-control" name="country_code">
                   @foreach($country_codes as $code)
                   <option value="{{$code->id}}" {{$code->id == $store->country_code_id?'selected':''}}>{{get_local_name($code->name_ar,$code->name_en).'-'.$code->code}}</option>
                   @endforeach
               </select>
           </div>
           <div class="col-md-5">
           <div class="form-floating mb-3">
            <input type="text" name="phone" class="form-control" id="floatingInput" value="{{$store->phone}}" placeholder="{{__('stores.phone')}}">
            <label for="floatingInput">{{__('stores.phone')}}</label>
        </div>
           </div>
           <div class="col-md-5">
           <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" value="{{$store->email}}" placeholder="{{__('chef.email')}}">
            <label for="floatingInput">{{__('chef.email')}}</label>
        </div>
           </div>
       </div>
        <!-- <div class="form-floating mb-3">
            <input type="text" name="maps_url" class="form-control" id="floatingInput" value="{{$store->maps_url}}" placeholder="{{__('chef.maps_url')}}">
            <label for="floatingInput">{{__('chef.maps_url')}}</label>
        </div> -->
        <div class="row">
            <div class="col-md-6">
                
                <div class="mb-3">
                <label for="floatingInput">{{__('chef.tax')}}</label>
                    <input type="text" name="tax" class="form-control" id="floatingInput" value="{{$store->tax}}">
                    
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{__('chef.tax_type')}}</label>
                <select class="form-select" name="tax_type">
                    <option value="PERCENT">{{__('chef.percent')}}</option>
                    <option value="AMOUNT">{{__('chef.amount')}}</option>
                </select>
            </div>
        </div>
        @foreach($roles as $role)
        @if($role->role->code == 'delivery')
        <div class="form-floating mb-3">
            <input type="number" name="min_delivery" class="form-control" id="floatingInput" value="{{$store->min_delivery}}" placeholder="{{__('chef.min_delivery')}}">
            <label for="floatingInput">{{__('chef.min_delivery')}}</label>
        </div>
         <label class="form-label">{{__('chef.delivery_fees')}}</label>
        <div class="input-group mb-3">
            <input type="number" class="form-control" name="delivery_fees" placeholder="0.0" value="{{$store->delivery_fees}}">
            <span class="input-group-text" id="basic-addon1">{{$currency->code}}</span>
        </div>
        <!--<div class="mb-3">
            <label class="form-label">{{__('chef.delivery_area')}} <span id="area">{{$store->delivery_distance??0}}</span> km</label>
            <input type="range" class="form-range" name="delivery_distance" value="{{$store->delivery_distance??0}}" onchange="addCircle(this.value)">
        </div> -->
        @endif
        @endforeach
        <div class="mb-3">
            <input type="hidden" id="lat" name="latitude" value="{{$store->latitude}}">
            <input type="hidden" id="lng" name="longtude" value="{{$store->longtude}}">
            <label class="form-label">{{__('chef.location_on_map')}}</label>
            <div id="map"></div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
        </div>

    </form>
</div>