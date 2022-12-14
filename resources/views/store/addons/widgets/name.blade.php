@switch($store->lang_code)
@case('ar')
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" name="name_ar" value="@if(isset($addon)){{$addon->name_ar}}@else{{old('name_ar')}}@endif" placeholder="{{__('addons.name_ar')}}">
  <label for="floatingInput">{{__('addons.name_ar')}}</label>
</div>
@break
@case('en')
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" name="name_en" value="@if(isset($addon)){{$addon->name_en}}@else{{old('name_en')}}@endif" placeholder="{{__('addons.name_en')}}">
  <label for="floatingInput">{{__('addons.name_en')}}</label>
</div>
@break
@default
<div class="row">
  <div class="col-md-6">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="floatingInput" name="name_ar" value="@if(isset($addon)){{$addon->name_ar}}@else{{old('name_ar')}}@endif" placeholder="{{__('addons.name_ar')}}">
      <label for="floatingInput">{{__('addons.name_ar')}}</label>
    </div>
  </div>
  <div class="col-md-6">

    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="floatingInput" name="name_en" value="@if(isset($addon)){{$addon->name_en}}@else{{old('name_en')}}@endif" placeholder="{{__('addons.name_en')}}">
      <label for="floatingInput">{{__('addons.name_en')}}</label>
    </div>
  </div>
</div>
@endswitch