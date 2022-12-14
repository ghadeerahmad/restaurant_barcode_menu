@switch($store->lang_code)
@case('ar')
<div class="mb-3">
    <textarea placeholder="{{__('coupons.description_ar')}}" class="form-control" name="description_ar">@if(isset($coupon)){{$coupon->description_ar}}@else{{old('description_ar')}}@endif</textarea>

</div>
@break;
@case('en')
<div class="mb-3">
    <textarea placeholder="{{__('coupons.description_en')}}" class="form-control" name="description_en">@if(isset($coupon)){{$coupon->description_en}}@else{{old('description_en')}}@endif</textarea>

</div>
@break;
@default
<div class="row">
    <div class="col-md-6">
    <div class="mb-3">
    <textarea placeholder="{{__('coupons.description_ar')}}" class="form-control" name="description_ar">@if(isset($coupon)){{$coupon->description_ar}}@else{{old('description_ar')}}@endif</textarea>

</div>
    </div>
    <div class="col-md-6">
    <div class="mb-3">
    <textarea placeholder="{{__('coupons.description_en')}}" class="form-control" name="description_en">@if(isset($coupon)){{$coupon->description_en}}@else{{old('description_en')}}@endif</textarea>

</div>
    </div>
</div>
@endswitch