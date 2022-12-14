@switch($store->lang_code)
@case('ar')
<div class="form-floating mb-3">
    <textarea class="form-control" name="description_ar" id="floatingInput" placeholder="{{__('branches.name_ar')}}">@if(isset($branch)){{$branch->description_ar}}@else{{old('description_ar')}}@endif</textarea>
    <label for="floatingInput">{{__('branches.description_ar')}}</label>
</div>
@break
@case('en')
<div class="form-floating mb-3">
    <textarea class="form-control" name="description_en" value="" id="floatingInput" placeholder="{{__('branches.description_en')}}">@if(isset($branch)){{$branch->description_en}}@else{{old('description_en')}}@endif</textarea>
    <label for="floatingInput">{{__('branches.description_en')}}</label>
</div>
@break
@default
<div class="row">
    <div class="col-md-6">

        <div class="form-floating mb-3">
            <textarea class="form-control" name="description_ar" id="floatingInput" placeholder="{{__('branches.name_ar')}}">@if(isset($branch)){{$branch->description_ar}}@else{{old('description_ar')}}@endif</textarea>
            <label for="floatingInput">{{__('branches.description_ar')}}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <textarea class="form-control" name="description_en" value="" id="floatingInput" placeholder="{{__('branches.description_en')}}">@if(isset($branch)){{$branch->description_en}}@else{{old('description_en')}}@endif</textarea>
            <label for="floatingInput">{{__('branches.description_en')}}</label>
        </div>
    </div>
</div>
@endswitch