@extends('layouts.storeAdmin')
@section('title',__('stores.stores'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <div class="text-right"><a type="button" href="{{url('store/create')}}" class="btn btn-primary">{{__('stores.add')}}</a></div><br>
        @if(count($stores) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('stores.name_ar')}}</th>
                    <th>{{__('stores.name_en')}}</th>
                    <th>{{__('stores.is_active')}}</th>
                    <th>{{__('stores.created_at')}}</th>
                    <th>{{__('stores.is_branch')}}</th>
                    <th>{{__('stores.parent')}}</th>
                    <th>{{__('stores.status')}}</th>
                    <th>{{__('stores.actions')}}</th>

                </thead>
                <tbody>
                    @foreach($stores as $value)
                    <tr>
                        <td>{{$value->store->name_ar}}</td>
                        <td>{{$value->store->name_en}}</td>
                        <td>
                            <form id="changeVisible">
                                <input type="hidden" id="store_id" name="store_id" value="{{$value->store->id}}">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status" onchange="change_status({{$value->store->id}})" type="checkbox" id="status" {{$value->store->status==1?'checked':''}}>
                                </div>
                            </form>
                        </td>
                        <td>{{$value->store->created_at}}</td>
                        <td>{{$value->store->parent_id == null?__('stores.no'):__('stores.yes')}}</td>
                        <td>{{$value->store->parent_id != null?App::isLocale('ar')?$value->store->parent->name_ar:$value->store->parent->name_ar:''}}</td>
                        <td>
                            @switch($value->store->status)
                            @case(0)
                            <span class="badge bg-secondary">{{__('stores.waiting_approv')}}</span>
                            @break
                            @case(1)
                            <span class="badge bg-success">{{__('stores.active')}}</span>
                            @break
                            @case(2)
                            <span class="badge bg-danger text-center">{{__('stores.disabled_by_owner')}}</span>
                            @break
                            @case(3)
                            <span class="badge bg-secondary">{{__('stores.disabled')}}</span>
                            @break
                            @endswitch
                        </td>
                        <td>

                            <a href="{{url('store/delete',$value->id)}}" data-toggle="tooltip" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>



                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h4 class="text-center">{{__('stores.no_stores')}}</h4>
        @endif
    </div>
    <!-- The actual snackbar -->
    <div id="snackbar"></div>
</section>
@endsection
@section('js')
@include('store.scripts.store_enable_disable')
@endsection