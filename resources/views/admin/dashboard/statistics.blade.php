@extends('layouts.admin')
@section('title',__('dashboard.statistics'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <form action="{{url('admin/filter_orders')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    
                <label class="form-label">{{__('dashboard.from')}}</label>
                <input type="date" class="form-control" name="start" id="start_date">
                </div>
            </div>
            <div class="col-md-4"><div class="mb-3">
                
            <label class="form-label">{{__('dashboard.to')}}</label>
                <input type="date" class="form-control" name="end" id="end_date">
            </div>
            </div>
            <div class="col-md-4"><br>
                <div class="mb-3">
                <button type="submit" class="btn btn-primary">{{__('dashboard.submit')}}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="container">
        <form method="GET" action="{{url('admin/store_sheet')}}">
            <input type="hidden" name="start" id="start">
            <input type="hidden" name="end" id="end">
            <div class="d-grid gap-2 col-12 mx-auto">
                <button type="submit" class="btn btn-primary">{{__('dashboard.export')}}</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>{{__('dashboard.store_name')}}</th>
                <th>{{__('dashboard.email')}}</th>
                <th>{{__('dashboard.phone')}}</th>
                <th>{{__('dashboard.branches')}}</th>
                <th>{{__('dashboard.tables')}}</th>
                <th>{{__('dashboard.categories')}}</th>
                <th>{{__('dashboard.products')}}</th>
                <th>{{__('dashboard.orders')}}</th>
                <th>{{__('dashboard.orders_value')}}</th>
                <th>{{__('dashboard.plan')}}</th>
                <th>{{__('dashboard.created_at')}}</th>
                <th>{{__('dashboard.end_date')}}</th>
                <th>{{__('dashboard.sub_value')}}</th>
            </thead>
            <tbody>
                @foreach($stores as $store)
                    <tr>
                        <td>{{get_local_name($store->name_ar,$store->name_en)}} </td>
                        <td>{{$store->email}}</td>
                        <td>{{$store->phone}}</td>
                        <td>{{count($store->branches)}}</td>
                        <td>{{count($store->tables)}}</td>
                        <td>{{count($store->product_categories)}}</td>
                        <td>{{count($store->products)}}</td>
                        <td>
                            @php $count = 0; @endphp
                            @if(isset($orders))
                            @foreach($orders as $order)
                            @if($order->store_id == $store->id)
                            @if($order->ordersCount > 0) @php $count = $order->ordersCount; @endphp @endif
                            @endif
                            @endforeach
                            {{$count}}
                            @else
                            {{count($store->orders)}}
                            @endif
                        </td>
                        <td>
                        @php $total = 0; @endphp
                        @if(isset($orders))
                            @foreach($orders as $order)
                            @if($order->store_id == $store->id)
                                @php $total += $order->total; @endphp
                            @endif
                            @endforeach
                            @else    
                            @foreach($store->orders as $order)
                                @php $total += $order->total; @endphp
                            @endforeach
                            @endif
                            {{$total}}
                        </td>
                        <td>{{get_local_name($store->plan->name_ar,$store->plan->name_en)}}</td>
                        <td>{{$store->created_at}}</td>
                        <td>{{$store->sub_end}}</td>
                        <td>{{$store->plan->price.$store->plan->currency->code}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('js')
<script>
    function getDate(date){
        var dt = new Date(date);
        return dt.toDateString();
    }
    $(document).ready(function(){
        $("#start_date").change(function(){
            var start = $("#start_date").val();
            $("#start").val(start);
        });
        $("#end_date").change(function(){
            var end = $("#end_date").val();
            $("#end").val(end);
        });
    });
</script>
@endsection