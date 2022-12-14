@extends('layouts.admin')
@section('title',__('admin.add_store_privilege'))
@section('content')
<section id="main">
    <div class="container col-md-10 shadow-lg">
        <form action="{{url('admin/stores/privileges/update',$privilege->id)}}" method="POST">
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
                        <input type="text" class="form-control" id="floatingInput" name="name_ar" value="{{$privilege->name_ar}}" placeholder="{{__('admin.privilege_name_ar')}}">
                        <label for="floatingInput">{{__('admin.privilege_name_ar')}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="name_en" value="{{$privilege->name_en}}" placeholder="{{__('admin.privilege_name_en')}}">
                        <label for="floatingInput">{{__('admin.privilege_name_en')}}</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('admin.is_default')}}</label>
                <select class="selectpicker form-control" name="is_default">
                    <option value="0" {{$privilege->is_default == 0?'selected':''}}>{{__('admin.no')}}</option>
                    <option value="1" {{$privilege->is_default == 1?'selected':''}}>{{__('admin.yes')}}</option>
                </select>
            </div>
            <div class="row">
                @foreach($roles as $group => $role)
                <div class="col-md-3">
                    <p><strong>{{$group}}</strong></p>
                    @foreach($role as $value)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$value->id}}" @foreach($privilege_roles as $rl) @if($rl->store_role_id == $value->id) {{'checked'}} @endif @endforeach name="roles[]" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{$value->name}}
                        </label>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary">{{__('admin.save')}}</button>
            </div>
        </form>
    </div>
</section>
@endsection