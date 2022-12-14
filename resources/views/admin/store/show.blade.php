@extends('layouts.admin')
@section('title',App::isLocale('ar')?$store->name_ar:$store->name_en)
@section('content')
<section id="main">
    <div class="container col-md-11" style="background-color: transparent;">
        <h2>{{App::isLocale('ar')?$store->name_ar:$store->name_en}}</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="container shadow">
                    <div class="row">
                    <div class="col-2">
                        <button type="button" class="btn btn-primary">
                            <i class="fab fa-product-hunt"></i>
                        </button>
                    </div>
                    <div class="col-10">
                    <h4 class="text-center">{{__('stores.products_count')}}</h4>
                    <p class="text-center"><strong>{{count($products)}}</strong></p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container shadow">
                    <div class="row">
                    <div class="col-2">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-chart-pie"></i>
                        </button>
                    </div>
                    <div class="col-10">
                    <h4 class="text-center">{{__('stores.categories_count')}}</h4>
                    <p class="text-center"><strong>{{count($product_categories)}}</strong></p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container shadow">
                    <div class="row">
                    <div class="col-2">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-calendar-alt"></i>
                        </button>
                    </div>
                    <div class="col-10">
                    <h4 class="text-center">{{__('stores.orders_count')}}</h4>
                    <p class="text-center"><strong>{{count($orders)}}</strong></p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection