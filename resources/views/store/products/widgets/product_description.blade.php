@switch($lang_code)
@case('ar')
<div class="mb-3">
    <textarea placeholder="{{__('chef.product_description_ar')}}" class="form-control" name="description_ar">@if(isset($product)){{$product->description_ar}}@else{{old('description_ar')}}@endif</textarea>

</div>
@break;
@case('en')
<div class="mb-3">
    <textarea placeholder="{{__('chef.product_description_en')}}" class="form-control" name="description_en">@if(isset($product)){{$product->description_en}}@else{{old('description_en')}}@endif</textarea>

</div>
@break;
@default
<div class="row">
    <div class="col-md-6">
    <div class="mb-3">
    <textarea placeholder="{{__('chef.product_description_ar')}}" class="form-control" name="description_ar">@if(isset($product)){{$product->description_ar}}@else{{old('description_ar')}}@endif</textarea>

</div>
    </div>
    <div class="col-md-6">
    <div class="mb-3">
    <textarea placeholder="{{__('chef.product_description_en')}}" class="form-control" name="description_en">@if(isset($product)){{$product->description_en}}@else{{old('description_en')}}@endif</textarea>

</div>
    </div>
</div>
@endswitch