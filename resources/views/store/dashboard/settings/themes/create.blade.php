@extends('layouts.storeAdmin')
@section('title',__('themes.create'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <form method="POST" action="{{url('store/themes/create')}}" enctype="multipart/form-data">
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
                    <div><img src="{{asset('image/bg.png')}}" width="150" id="preview"></div>
                    <input type="file" name="background_image" id="image">
            </div>
            <div class="col-md-6">
                    <label class="form-label">{{__('themes.intro_image')}}</label>
                    <div><img src="{{asset('image/intro-back.png')}}" width="150" id="intro_preview"></div>
                    <input type="file" name="intro_image" id="intro_image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.container_back_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="container_back_color" value="#ffffff">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.container_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="container_fore_color" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.price_back_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="price_back_color" value="#F9595A">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('themes.price_font_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="price_font_color" value="#ffffff">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.primary_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="primary_color" value="#FCC02C">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.secondary_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="secondary_color" value="#FCC02C">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{__('themes.font_color')}}</label>
                        <input type="color" class="form-control form-control-color" name="font_color" value="#00000">
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
        $('#intro_image').change(function() {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#intro_preview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection