@switch($store->lang_code)
@case('ar')
<div class="form-floating mb-3">
    <textarea class="form-control" name="address_ar" id="floatingInput" placeholder="{{__('branches.name_ar')}}">@if(isset($branch)){{$branch->address_ar}}@else{{old('address_ar')}}@endif</textarea>
    <label for="floatingInput">{{__('branches.address_ar')}}</label>
</div>
@break
@case('en')
<div class="form-floating mb-3">
    <textarea class="form-control" name="address_en" value="" id="floatingInput" placeholder="{{__('branches.address_en')}}">@if(isset($branch)){{$branch->address_en}}@else{{old('address_en')}}@endif</textarea>
    <label for="floatingInput">{{__('branches.address_en')}}</label>
</div>
@break
@default
<div class="row">
    <div class="col-md-6">

        <div class="form-floating mb-3">
            <textarea class="form-control" name="address_ar" id="floatingInput" placeholder="{{__('branches.name_ar')}}">@if(isset($branch)){{$branch->address_ar}}@else{{old('address_ar')}}@endif</textarea>
            <label for="floatingInput">{{__('branches.address_ar')}}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <textarea class="form-control" name="address_en" value="" id="floatingInput" placeholder="{{__('branches.address_en')}}">@if(isset($branch)){{$branch->address_en}}@else{{old('address_en')}}@endif</textarea>
            <label for="floatingInput">{{__('branches.address_en')}}</label>
        </div>
    </div>
</div>
@endswitch