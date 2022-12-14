@extends('layouts.admin')
@section('title',App::isLocale('ar')?$order->store->name_ar:$order->store->name_en)
@section('css')
<style>
#preview{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #000000d6;
    text-align: center;
    display: none;
    transition: .5s all ease-in-out;
    z-index: 999999999;
}
#preview img{
    margin: auto;
    display: flex;
}
#preview button{
    position: absolute;
    z-index: 999999999999;
    color: white;
    top: 0;
    right: 25px;
    background-color: transparent;
    border: none;
    font-weight: bold;
    font-size: 35px;
}
</style>
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
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
        <h3>{{App::isLocale('ar')?$order->store->name_ar:$order->store->name_en}}</h3>
        <p><strong>{{__('plans.plan_requested')}}</strong>: {{App::isLocale('ar')?$order->plan->name_ar:$order->plan->name_en}}</p>
        <p><strong>{{__('plans.price')}}</strong>: {{$order->plan->price}}</p>
        <p><strong>{{__('plans.sub_type')}}</strong>:
            @switch($order->plan->sub_type)
            @case('MONTH')
            {{App::isLocale('ar')?'شهري':'Monthly'}}
            @break
            @case('YEAR')
            {{App::isLocale('ar')?'سنوي':'Yearly'}}
            @break
            @endswitch
        </p>
        <p><strong>{{__('plans.order_total')}}: </strong>{{$order->total}}</p>
        <p><strong>{{__('plans.branche_count')}}: </strong>{{$order->branche_count}}</p>
        <p><strong>{{__('plans.payment_method')}}</strong>: {{App::isLocale('ar')?$order->payment_method->title_ar:$order->payment_method->title_en}}</p>
        @if($order->image != null)
        <div class="container col-md-6">
            <img src="{{asset('storage/'.$order->image)}}" id="img" width="50%">
            
        </div>
        @endif
        @if($order->payment_number != null)
        <p><strong>{{__('plans.payment_num')}}</strong>: {{$order->payment_number}}</p>
        @endif
        <p><strong>{{__('plans.order_status')}}</strong>:
            @switch($order->status)
            @case(0)
            {{__('plans.waiting_approv')}}
            @break
            @case(1)
            {{__('plans.approved')}}
            @break
            @case(2)
            {{__('plans.rejected')}}
            @break
            @endswitch
        </p>
        @if($order->status != 1)
        <div class="row">
            <div class="col-md-4">
                <form method="POST" action="{{url('admin/plans/orders/approve',$order->id)}}">
                    @csrf
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button type="submit" class="btn btn-success">{{__('plans.approve')}}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form method="POST" action="{{url('admin/plans/orders/decline',$order->id)}}">
                    @csrf
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button type="submit" class="btn btn-danger">{{__('plans.reject')}}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form method="POST" action="{{url('admin/plans/orders/delete',$order->id)}}">
                    @csrf
                    @method('DELETE')
                    <div class="d-grid gap-2 col-12 mx-auto">
                        <button type="submit" class="btn btn-danger">{{__('plans.delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div id="preview">
                <button id="btn">X</button>
            <img src="{{asset('storage/'.$order->image)}}">
            </div>
</section>
@endsection
@section('js')
<script>
$(document).ready(function(){
    $("#img").click(function(e){
        $("#preview").attr('style','display:flex');
    });
    $("#btn").click(function(e){
        $("#preview").attr('style','display:none');
    });
});
    </script>
@endsection