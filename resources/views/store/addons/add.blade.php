@extends('layouts.storeAdmin')
@section('title',__('chef.add_addon'))
@section('content')
<div id="main">
    <div class="container col-md-6 shadow-lg">
        <form action="{{url('store/addons/add')}}" method="POST">
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
            @include('store.addons.widgets.name')
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="price" aria-label="price" name="price" aria-describedby="basic-addon1" value="{{old('price')}}">

                <span class="input-group-text" id="basic-addon1">{{$currency->code}}</span>
                @error('price')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @endif
            </div>

            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">{{__('chef.save')}}</button>
            </div>
        </form>
    </div>
</div>
@endsection