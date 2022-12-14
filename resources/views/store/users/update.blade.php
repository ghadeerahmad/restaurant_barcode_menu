@extends('layouts.storeAdmin')
@section('title',__('users.update'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form method="POST" action="{{route('store.admins.update',['id'=>$user->id])}}">
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
                        <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" id="floatingInput" placeholder="{{__('users.first_name')}}">
                        <label for="floatingInput">{{__('users.first_name')}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" id="floatingInput" placeholder="{{__('users.last_name')}}">
                        <label for="floatingInput">{{__('users.last_name')}}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" id="floatingInput" placeholder="{{__('users.email')}}">
                        <label for="floatingInput">{{__('users.email')}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" value="{{$user->password}}" id="floatingInput" placeholder="{{__('users.password')}}">
                        <label for="floatingInput">{{__('users.password')}}</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('users.privilege')}}</label>
                <select name="privilege" class="selectpicker form-control">
                    @foreach($privileges as $privilege)
                    <option value="{{$privilege->id}}" @if($privilege->id == $privilege_id){{'selected'}}@endif>{{App::isLocale('ar')?$privilege->name_ar:$privilege->name_en}}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary">
                    {{__('users.update')}}
                </button>
            </div>
        </form>
    </div>
</section>
@endsection