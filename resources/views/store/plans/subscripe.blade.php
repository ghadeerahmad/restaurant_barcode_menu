@extends('layouts.storeAdmin')
@section('title',__('plans.subscripe'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form action="{{url('store/plans/confirm_order')}}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" id="plan_id" value="{{$plan->id}}">
        <h2>{{App::isLocale('ar')?$plan->name_ar:$plan->name_en}}</h2>
        <p style="text-align: justify;">{{App::isLocale('ar')?$plan->description_ar:$plan->description_en}}</p>
        <p>{{__('plans.price')}}: {{$plan->price == 0?'free':$plan->price.$plan->currency->code}}</p>

        @php $hasBranches = $plan->hasRole('branches'); @endphp
        <div class="row">
            <div class="col-md-6">
                <p>{{__('plans.allow_branches')}}: {{$hasBranches?__('plans.yes'):__('plans.no')}}</p>
            </div>
            @if($hasBranches)
            <div class="col-md-6">
                <label class="form-label">{{__('plans.branche_count')}}</label>
                <input type="number" oninput="calcTotal()" class="form-control" name="branche_count" value="0" id="branche_count" />
            </div>
            @endif
        </div>
        <p>{{__('plans.allow_tables')}}: @if($plan->hasRole('tables')){{__('plans.yes')}}@else{{__('plans.no')}}@endif</p>
        <p>{{__('plans.allow_delivery')}}: @if($plan->hasRole('delivery')){{__('plans.yes')}}@else{{__('plans.no')}}@endif</p>
        <p><strong>{{__('plans.order_total')}}: </strong><span id="order_total">{{$plan->price}}</span>{{$plan->currency->code}}</p>
        <div class="d-grid gap-2 mx-auto">
            @if(auth()->user()->hasStoreRole('modify_plan')) <button type="submit" class="btn btn-success">{{__('plans.confirm_payment')}}</button>@endif
        </div>
        </form>
    </div>
</section>
@endsection
@section('js')
<script>
    var price = "{{ $plan->price }}";

    function calcTotal() {
        var count = $("#branche_count").val();
        if (count > 0) {
            var total = parseFloat(price) * parseInt(count);
            $("#order_total").html(total);
        }
    }
</script>
@endsection