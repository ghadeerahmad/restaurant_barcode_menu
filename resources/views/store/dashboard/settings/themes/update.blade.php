@extends('layouts.storeAdmin')
@section('title',__('themes.update'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <form method="POST" action="{{url('store/themes/update',$theme->id)}}" enctype="multipart/form-data">
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
            <div class="col-md-6">
                    <label class="form-label">{{__('themes.background_image')}}</label>
                    <div><img src="{{$theme->background_image==null?asset('image/bg.png'):asset('storage/'.$theme->backgruond_image)}}" width="150" id="preview"></div>
                    <input type="file" name="background_image" id="image">
            </div>
            <div class="col-md-6">
                    <label class="form-label">{{__('themes.intro_image')}}</label>
                    <div><img src="{{$theme->intro_image==null?asset('image/intro-back.png'):asset('storage/'.$theme->intro_image)}}" width="150" id="intro_preview"></div>
                    <input type="file" name="intro_image" id="intro_image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.container_back_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="container_back_color" value="{{$theme->information_class_background}}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.container_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="container_fore_color" value="{{$theme->information_class_color}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.price_back_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="price_back_color" value="{{$theme->price_back_color}}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.price_font_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="price_font_color" value="{{$theme->price_font_color}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.primary_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="primary_color" value="{{$theme->primary_color}}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.secondary_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="secondary_color" value="{{$theme->secondary_color}}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.font_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="font_color" value="{{$theme->font_color}}">
                    </div>
                </div> 
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">{{__('themes.is_active')}}</label>
            <select class=" form-select" name="is_active">
                <option value="0">{{__('themes.no')}}</option>
                <option value="1">{{__('themes.yes')}}</option>
            </select>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('themes.save')}}</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    $(document).ready(() => {
        $('#image').change(function() {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection