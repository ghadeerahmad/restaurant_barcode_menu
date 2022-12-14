@switch($store->lang_code) 
@case('ar')
<div class="mb-3">
    <input type="text" placeholder="{{__('coupons.name_ar')}}" class="form-control" name="name_ar" value="@if(isset($coupon)) {{$coupon->name_ar}}@else{{old('name_ar')}}@endif">

</div>
@break;
@case('en')
<div class="mb-3">
    <input type="text" placeholder="{{__('coupons.name_en')}}" class="form-control" name="name_en" value="@if(isset($coupon)) {{$coupon->name_en}}@else{{old('name_en')}}@endif">

</div>
@break;
@default
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="{{__('coupons.name_ar')}}" name="name_ar" value="@if(isset($coupon)){{$coupon->name_ar}}@else{{old('name_ar')}}@endif">

        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <input type="text" placeholder="{{__('coupons.name_en')}}" class="form-control" name="name_en" value="@if(isset($coupon)){{$coupon->name_en}}@else{{old('name_en')}}@endif">

        </div>
    </div>
</div>
@endswitch