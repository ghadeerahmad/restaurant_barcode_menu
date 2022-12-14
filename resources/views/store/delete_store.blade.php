@extends('layouts.storeAdmin')
@section('title',__('stores.delete'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <h2>{{App::isLocale('ar')?$store->name_ar:$store->name_en}}</h2>
        <p>{{App::isLocale('ar')?$store->description_ar:$store->description_en}}</p>
        <p><strong>{{__('stores.product_count')}}: </strong>{{count($store->products)}}</p>
        <p><strong>{{__('stores.category_count')}}: </strong>{{count($store->product_categories)}}</p>
        <div class="alert alert-danger text-center">{{__('stores.delete_confirm')}}</div>
        <form method="post" action="{{url('store/delete',$store->id)}}" id="delete-addons-{{$store->id}}">
            @csrf
            @method('DELETE')
        <div class="d-grid gap-2 col-6 mx-auto">
        <button type="submit" class="btn btn-danger">{{__('stores.delete')}}</button>
        </div>
        </form>
    </div>
</section>
@endsection