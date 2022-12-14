@switch($store->lang_code)
 @case('ar')
      <div class="form-floating mb-3">
           <input type="text" class="form-control" id="floatingInput" name="title_ar" placeholder="{{__('chef.title_ar')}}" value="@if(isset($store_payment_method)){{$store_payment_method->title_ar}}@else{{old('title_ar')}}@endif">
           <label for="floatingInput">{{__('chef.title_ar')}}</label>                                                               
      </div>
 @break

 @case('en')
      <div class="form-floating mb-3">
           <input type="text" class="form-control" id="floatingInput" name="title_en" placeholder="{{__('chef.title_en')}}" value="@if(isset($store_payment_method)){{$store_payment_method->title_en}}@else{{old('title_en')}}@endif">
           <label for="floatingInput">{{__('chef.title_en')}}</label>
      </div>
 @break

 @default
       <div class="form-floating mb-3">
           <input type="text" class="form-control" id="floatingInput" name="title_ar" placeholder="{{__('chef.title_ar')}}" value="@if(isset($store_payment_method)){{$store_payment_method->title_ar}}@else{{old('title_ar')}}@endif">
           <label for="floatingInput">{{__('chef.title_ar')}}</label>                                                                 
       </div>
       <div class="form-floating mb-3">
           <input type="text" class="form-control" id="floatingInput" name="title_en" placeholder="{{__('chef.title_en')}}" value="@if(isset($store_payment_method)){{$store_payment_method->title_en}}@else{{old('title_en')}}@endif">
           <label for="floatingInput">{{__('chef.title_en')}}</label>
      </div>
@endswitch