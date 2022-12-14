@extends('layouts.admin')
@section('title',__('admin.store_plan'))
@section('content')
<section id="main">
    <div class="container col-md-5 shadow-lg">
        <form action="{{url('admin/store/update_plan',$store->id)}}" method="POST">
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
            <div class="mb-3">
                <label class="form-label">{{__("admin.store_plan")}}</label>
                <select class="selectpicker form-control" id="plan" name="plan_id">
                    @foreach($plans as $plan)
                    <option value="{{$plan->id}}" {{$store->plan_id == $plan->id?'selected':''}}>{{$plan->name_ar}}-{{$plan->name_en}}</option>
                    @endforeach
                </select>

            </div>
            <div class="mb-3">
                <label class="form-label">{{__('admin.sub_end')}}</label>
                <input type="date" class="form-control" id="date" name="sub_end">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">{{__('chef.save')}}</button>
            </div>
        </form>
    </div>
</section>
@endsection