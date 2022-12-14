@extends('layouts.storeAdmin')
@section('title',__('tables.add'))
@section('content')
<section id="main">
    <div class="container col-md-6 shadow-lg">
        <form action="{{url('store/tables/add')}}" method="POST">
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
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="{{__('tables.name')}}" value="{{old('name')}}" name="name">
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" name="is_active" type="checkbox" id="flexSwitchCheckDefault" checked>
                    <label class="form-check-label" for="flexSwitchCheckDefault">{{__('tables.is_active')}}</label>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
            </div>
        </form>
    </div>
</section>
@endsection