@extends('layouts.storeAdmin')
@section('title',__('chef.inventory'))
@section('css')

<style>
    .float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #322A7D;
        color: #FFA101;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
    }


    .my-float {
        margin-top: 22px;
    }

    .container {
        margin-top: 50px;
        background-color: #fff;
        border-radius: 25px;
        padding: 20px 25px;
    }
</style>
@endsection
@section('content')

<div id="main">
    <div class="container col-md-11 shadow-lg">
        <div class="row layout-top-spacing layout-spacing">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Tabs nav -->
                        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">{{__('chef.category')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{{__('chef.products')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{{__('chef.addons')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="edits-tab" data-bs-toggle="tab" data-bs-target="#edits" type="button" role="tab" aria-controls="contact" aria-selected="false">{{__('chef.edits')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sauces-tab" data-bs-toggle="tab" data-bs-target="#sauces" type="button" role="tab" aria-controls="contact" aria-selected="false">{{__('chef.sauces')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sizes-tab" data-bs-toggle="tab" data-bs-target="#sizes" type="button" role="tab" aria-controls="contact" aria-selected="false">{{__('chef.sizes')}}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><br>
                                @if(auth()->user()->hasStoreRole('create_category'))
                                <div class="text-right">

                                    <a href="{{url('store/categories/add')}}" type="button" class="btn btn-primary">{{__('chef.add_category')}}</a>

                                </div>
                                @endif
                                @if(count($cates) == 0)
                                <div>
                                    <h4 class="text-center">{{__('chef.no_categories')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.categories')
                                @endif
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><br>
                                <div class="text-right">

                                    <a href="{{url('store/products/add')}}" type="button" class="btn btn-primary">{{__('chef.add_product')}}</a>

                                </div>
                                @if(count($products) == 0)
                                <div class="container">
                                    <h4 class="text-center">{{__('chef.no_products')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.products')
                                @endif
                            </div>



                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="text-right">

                                    <a href="{{url('store/addons/add')}}" type="button" class="btn btn-primary">{{__('chef.add_addon')}}</a>

                                </div>
                                @if(count($addons) == 0)
                                <div class="container">
                                    <h4 class="text-center">{{__('chef.no_addons')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.addons')
                                @endif
                            </div>
                            <div class="tab-pane fade" id="edits" role="tabpanel" aria-labelledby="edits-tab">
                                <div class="text-right">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_edit">
                                        {{__('chef.add_edit')}}
                                    </button>
                                </div>
                                @if(count($edits) == 0)
                                <div class="container">
                                    <h4 class="text-center">{{__('chef.no_edits')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.edits')
                                @endif

                            </div>
                            <div class="tab-pane fade" id="sauces" role="tabpanel" aria-labelledby="sauces-tab">
                                <br>

                                <div class="text-right">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_sauce">
                                        {{__('chef.add_sauce')}}
                                    </button>
                                </div>
                                @if(count($sauces) == 0)
                                <div class="container">
                                    <h4 class="text-center">{{__('chef.no_sauces')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.sauces')
                                @endif

                            </div>
                            <div class="tab-pane fade" id="sizes" role="tabpanel" aria-labelledby="sizes-tab">
                                <br>

                                <div class="text-right">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_size">
                                        {{__('chef.add_size')}}
                                    </button>
                                </div>
                                @if(count($sizes) == 0)
                                <div class="container">
                                    <h4 class="text-center">{{__('chef.no_sizes')}}</h4>
                                </div>
                                @else
                                @include('store.dashboard.inventory.sizes')
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('chef.add_edit')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('store/edits/add')}}" id="add_edit_form" method="POST">
                        @csrf
                        @include('store.dashboard.edits.widgets.name')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('chef.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('add_edit_form').submit();">{{__('chef.save')}}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_sauce" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('chef.add_sauce')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('store/sauces/add')}}" id="add_sauce_form" method="POST">
                        @csrf
                        @include('store.dashboard.sauces.widgets.name')
                        <div class="mb-3">
                            <input type="number" class="form-control" name="price" placeholder="{{__('chef.price')}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('chef.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('add_sauce_form').submit();">{{__('chef.save')}}</button>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal fade" id="add_size" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('chef.add_size')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('store/sizes/add')}}" id="add_size_form" method="POST">
                        @csrf
                        @include('store.dashboard.sizes.widgets.name')
                        <div class="mb-3">
                            <input type="number" class="form-control" name="price" placeholder="{{__('chef.price')}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('chef.close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('add_size_form').submit();">{{__('chef.save')}}</button>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection