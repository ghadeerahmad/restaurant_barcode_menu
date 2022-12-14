@extends('layouts.admin')
@section('title',__('admin.store_plans'))
@section('content')
<section id="main">
    <div class="container col-md-11" style="background-color: transparent;">
        <div class="end">
            <a type="button" href="{{route('plans.create')}}" class="btn btn-primary"><i class="fa fa-add"></i> {{__('admin.add_plan')}}</a>
        </div>

        <div class="row" style="display: flex;">
            @foreach($plans as $plan)
            <div class="col-md-4" style="display:flex;flex-direction: row;">
                <div class="container shadow-lg">
                    <h5>{{$plan->name_ar}} - {{$plan->name_en}}</h5>
                    <p>{!! App::isLocale('ar')?$plan->description_ar:$plan->description_en !!}</p>
                    <p>{{__('admin.max_branches')}}: {{$plan->max_branches}}</p>
                    <ul>
                        @foreach($plan->plan_roles as $role)
                        <li>{{$role->role->name}}</li>
                        @endforeach
                    </ul>
                    <p>{{__('admin.price')}}: {{$plan->price}} {{$plan->currency->code}}</p>
                    @if($plan->is_default==1)<p><span class="badge bg-success">{{__('admin.default')}}</span></p>@endif
                    <div class="end">
                        <a type="button" class="btn btn-primary" href="{{route('plans.update',['id'=>$plan->id])}}" style="margin: 0 10px;"><i class="far fa-edit"></i></a> 
                        <form method="post" action="{{url('admin/plans/delete',$plan->id)}}" id="delete-product-{{$plan->id}}" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection