@extends('layouts.storeAdmin')
@section('title',__('plans.plans'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <h4>{{__('plans.active_plan')}}</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('plans.name')}}</th>
                    <th>{{__('plans.price')}}</th>
                    <th>{{__('plans.sub_type')}}</th>
                    <th>{{__('plans.end_date')}}</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{App::isLocale('ar')?$store->plan->name_ar:$store->plan->name_en}}</td>
                        <td>{{$store->plan->price == 0?'free':$store->plan->price.$store->plan->currency->code}}</td>
                        <td>{{$store->plan->sub_type == "MONTH"?__('plans.monthly'):__('plans.yearly')}}</td>
                        <td>{{$store->sub_end}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h4>{{__('plans.other_plans')}}</h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('plans.name')}}</th>
                    <th>{{__('plans.price')}}</th>
                    <th>{{__('plans.sub_type')}}</th>
                    <th>{{__('plans.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($plans as $value)
                    <tr>
                        <td>{{App::isLocale('ar')?$value->name_ar:$value->name_en}}</td>
                        <td>{{$value->price==0?'free':$value->price.$store->currency->code}}</td>
                        <td>{{$value->sub_type == "MONTH"?__('plans.monthly'):__('plans.yearly')}}</td>
                        <td>
                            <a type="button" class="btn btn-success" href="{{url('store/plans/details',$value->id)}}">{{__('plans.subscripe')}}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection