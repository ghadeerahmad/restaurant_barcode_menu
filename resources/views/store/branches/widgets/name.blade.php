@switch($store->lang_code)
@case('ar')
<div class="form-floating mb-3">
    <input type="text" class="form-control" name="name_ar" value="@if(isset($branch)){{$branch->name_ar}}@else{{old('name_ar')}}@endif" id="floatingInput" placeholder="{{__('branches.name_ar')}}">
    <label for="floatingInput">{{__('branches.name_ar')}}</label>
</div>
@break
@case('en')
<div class="form-floating mb-3">
    <input type="text" class="form-control" name="name_en" value="@if(isset($branch)){{$branch->name_en}}@else{{old('name_en')}}@endif" id="floatingInput" placeholder="{{__('branches.name_en')}}">
    <label for="floatingInput">{{__('branches.name_en')}}</label>
</div>
@break
@default
<div class="row">
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name_ar" value="@if(isset($branch)){{$branch->name_ar}}@else{{old('name_ar')}}@endif" id="floatingInput" placeholder="{{__('branches.name_ar')}}">
            <label for="floatingInput">{{__('branches.name_ar')}}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name_en" value="@if(isset($branch)){{$branch->name_en}}@else{{old('name_en')}}@endif" id="floatingInput" placeholder="{{__('branches.name_en')}}">
            <label for="floatingInput">{{__('branches.name_en')}}</label>
        </div>
    </div>
</div>
@endswitch