@extends('layouts.storeAdmin')
@section('title',__('orders.orders'))
@section('css')
<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 50%;
            margin: 1.75rem auto;
        }
    }
    .product-list{
        list-style: none;
        display: block;
        text-align: start;
    }
    .product-list li{
        display: block;
        text-align: start;
    }
    
</style>
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('orders.order_id')}}</th>
                    <th>{{__('orders.customer_name')}}</th>
                    <th>{{__('orders.table')}}</th>
                    <th>{{__('orders.status')}}</th>
                    <th>{{__('orders.total')}}</th>
                    <th>{{__('orders.created_at')}}</th>
                    <th>{{__('orders.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($orders as $value)
                    <tr>
                        <td>{{$value->order_unique_id}}</td>
                        <td>{{$value->customer_name}}</td>
                        <td>{{$value->table != null?$value->table->name:__('orders.no_table')}}</td>
                        <td>
                            @switch($value->status)
                            @case(0)
                            <span class="badge bg-secondary">{{__('orders.waiting')}}</span>
                            @break
                            @case(1)
                            <span class="badge bg-success">{{__('orders.accepted')}}</span>
                            @break
                            @case(2)
                            <span class="badge bg-primary">{{__('orders.paid')}}</span>
                            @break

                            @case(3)
                            <span class="badge bg-danger">{{__('orders.denied')}}</span>
                            @break

                            @case(4)
                            <span class="badge bg-info">{{__('orders.on_delivery')}}</span>
                            @break
                            @case(5)
                            <span class="badge bg-success">{{__('orders.completed')}}</span>
                            @break
                            @endswitch
                        </td>
                        <td>{{$value->total.' '.$store->currency->code}}</td>
                        <td>{{$value->created_at}}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="get_order({{$value->id}})">
                                <i class="far fa-eye" style="font-size: 20px;color:blue"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="order-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="order-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="customer-name" style="display: hidden;"></h4>
                <p id="phone" style="display: none;"></p>
                <p id="order-type"></p>
                <p id="map_url"></p>
                <p id="address"></p>
                <p id="comments"></p>
                <ul class="product-list" id="product-list"></ul>
                <p id="table" style="display: none;"><strong>{{__('orders.table')}}:</strong> <span id="table-name"></span></p>
                <p><strong>{{__('orders.total')}}:</strong> <span id="total">0</span> {{$store->currency->code}}</p>
                <p><strong>{{__('orders.payment_method')}}:</strong>
                    <sapn id="payment_method"></sapn>
                </p>
                <div id="payment_details" style="display: none;">
                    <div class="container" id="payment_image_container">
                        <img id="payment_image" width="100%">
                    </div>
                    <div id="payment_number">
                        <strong>{{__('orders.payment_number')}}:</strong> <span id="payment_num"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <form id="accept-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">{{__('orders.accept')}}</button>
                </form>
                @if(plan_has_role('delivery'))
                <form id="delivery-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info">{{__('orders.on_delivery')}}</button>
                </form>
                @endif
                <form id="deny-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{__('orders.deny')}}</button>
                </form>
                <form id="paid-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{__('orders.set_paid')}}</button>
                </form>
                <form id="completed-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{__('orders.completed')}}</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('store.orders.scripts.index')
@endsection