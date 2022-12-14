@switch($store->lang_code)
  @case('ar')
     <div class="form-floating">
          <textarea class="form-control" placeholder="{{__('chef.description_ar')}}" id="floatingTextarea" name="description_ar">@if(isset($store_payment_method)){{$store_payment_method->description_ar}}@else{{old('description_ar')}}@endif</textarea>
          <label for="floatingTextarea">{{__('chef.description_ar')}}</label>
     </div>
  @break

  @case('en')
      <div class="form-floating">
          <textarea class="form-control" placeholder="{{__('chef.description_en')}}" id="floatingTextarea" name="description_en">@if(isset($store_payment_method)){{$store_payment_method->description_en}}@else{{old('description_en')}}@endif</textarea>
          <label for="floatingTextarea">{{__('chef.description_en')}}</label>
      </div>
  @break

  @default
     <div class="form-floating mb-3">
          <textarea class="form-control" placeholder="{{__('chef.description_ar')}}" id="floatingTextarea" name="description_ar">@if(isset($store_payment_method)){{$store_payment_method->description_ar}}@else{{old('description_ar')}}@endif</textarea>
          <label for="floatingTextarea">{{__('chef.description_ar')}}</label>
     </div>
     <div class="form-floating mb-3">
          <textarea class="form-control" placeholder="{{__('chef.description_en')}}" id="floatingTextarea" name="description_en">@if(isset($store_payment_method)){{$store_payment_method->description_en}}@else{{old('description_en')}}@endif</textarea>
          <label for="floatingTextarea">{{__('chef.description_en')}}</label>
     </div>
@endswitch
