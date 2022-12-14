@extends('layouts.admin')
@section('title',__('plans.orders'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        @if(count($orders) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('plans.user_email')}}</th>
                    <th>{{__('plans.store')}}</th>
                    <th>{{__('plans.plan')}}</th>
                    <th>{{__('plans.payment_method')}}</th>
                    <th>{{__('plans.created_at')}}</th>
                    <th>{{__('plans.status')}}</th>
                    <th>{{__('plans.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($orders as $value)
                        <tr>
                            <td>{{$value->user->email}}</td>
                            <td>{{App::isLocale('ar')?$value->store->name_ar:$value->store->name_en}}</td>
                            <td>{{App::isLocale('ar')?$value->plan->name_ar:$value->plan->name_en}}</td>
                            <td>{{App::isLocale('ar')?$value->payment_method->title_ar:$value->payment_method->title_en}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>
                                @switch($value->status)
                                @case(0)
                                <span class="badge bg-secondary">{{__('plans.waiting_approv')}}</span>
                                @break
                                @case(1)
                                <span class="badge bg-success">{{__('plans.approved')}}</span>
                                @break
                                @case(2)
                                <span class="badge bg-danger">{{__('plans.rejected')}}</span>
                                @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{url('admin/plans/orders',$value->id)}}" style="font-size: 20px;"><i class="far fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h4 class="text-center">{{__('plans.no_orders')}}</h4>
        @endif
    </div>
</section>
@endsection