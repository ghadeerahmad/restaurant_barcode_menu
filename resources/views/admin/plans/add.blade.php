@extends('layouts.admin')
@section('title',__('admin.store_plans'))
@section('css')
<script src="//cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form method="POST" action="{{url('admin/plans/add')}}">
            @csrf
            @error('errors')
            <div class="alert alert-warning d-flex align-items-center alert-dismissible" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    {{$message}}
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <div class="form-floating mb-3">
                        <input type="text" name="name_ar" class="form-control" id="floatingInput" placeholder="{{__('admin.plan_name_ar')}}" value="{{old('name_ar')}}">
                        <label for="floatingInput">{{__('admin.plan_name_ar')}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" name="name_en" class="form-control" id="floatingInput" placeholder="{{__('admin.plan_name_en')}}" value="{{old('name_en')}}">
                        <label for="floatingInput">{{__('admin.plan_name_en')}}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="editor1">{{__('admin.plan_description_ar')}}</label>
                        <textarea name="description_ar" class="form-control" id="editor1" placeholder="{{__('admin.plan_description_ar')}}">{{old('description_ar')}}</textarea>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="editor2">{{__('admin.plan_description_en')}}</label>
                        <textarea name="description_en" class="form-control" id="editor2" placeholder="{{__('admin.plan_description_en')}}">{{old('description_en')}}</textarea>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="{{__('admin.price')}}" aria-label="{{__('admin.price')}}" aria-describedby="basic-addon1" name="price" value="{{old('price')}}">
                        <span class="input-group-text" id="basic-addon1">{{$currency->code}}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="number" name="period" class="form-control" id="floatingInput" placeholder="{{__('admin.period')}}" value="{{old('period')}}">
                        <label for="floatingInput">{{__('admin.period')}}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">{{__('admin.is_default')}}</label>
                        <select class="selectpicker form-control" name="is_default">
                            <option value="0">{{__('chef.no')}}</option>
                            <option value="1">{{__('chef.yes')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3 text-center">
            <div class="row">
                @foreach($roles as $role)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$role->id}}" name="roles[]" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$role->name}}
                        </label>
                    </div>
                </div>
                @endforeach
            </div></div><br>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary">{{__('chef.save')}}</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('js')
<script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
                CKEDITOR.replace( 'editor2' );
            </script>
@endsection