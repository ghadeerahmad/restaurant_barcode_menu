@extends("layouts.admin")

@section("content")

<div id="main">
    <div class="container col-11 shadow">
        <h4>{{__('chef.unapproved_store')}}</h4>
        @if(count($unapproved) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>{{__('chef.store_name_ar')}}</th>
                    <th>{{__('chef.store_name_en')}}</th>
                    <th>{{__('chef.created_at')}}</th>
                    <th>{{__('admin.is_branch')}}</th>
                    <th>{{__('admin.parent')}}</th>
                    <th>{{__('chef.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($unapproved as $store)
                    <tr>
                        <td>{{$store->id}}</td>
                        <td>{{$store->name_ar}}</td>
                        <td>{{$store->name_en}}</td>
                        <td>{{$store->created_at}}</td>
                        <td>{{$store->parent_id == null?__('admin.no'):__('admin.yes')}}</td>
                        <td>@if($store->parent_id != null){{get_local_name($store->name_ar,$store->name_en)}}@endif</td>
                        <td>
                            <form action="{{url('admin/store/approve',$store->id)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">{{__('chef.approve')}}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h5 class="text-center">{{__('chef.no_records')}}</h5>
        @endif

    </div>
    <div class="container col-11 shadow">
        <h4>{{__('chef.approved_store')}}</h4>
        @if(count($approved) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>{{__('chef.store_name_ar')}}</th>
                    <th>{{__('chef.store_name_en')}}</th>
                    <th>{{__('chef.created_at')}}</th>
                    <th>{{__('admin.sub_end')}}</th>
                    <th>{{__('admin.is_active')}}</th>
                    <th>{{__('admin.is_branch')}}</th>
                    <th>{{__('admin.parent')}}</th>
                    <th>{{__('chef.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($approved as $store)
                    <tr>
                        <td>{{$store->id}}</td>
                        <td>{{$store->name_ar}}</td>
                        <td>{{$store->name_en}}</td>
                        <td>{{$store->created_at}}</td>
                        <td>{{$store->sub_end}}</td>
                        <td>
                            <form id="changeVisible">
                                @csrf
                                <input type="hidden" id="store_id" name="store_id" value="{{$store->id}}">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="status" onchange="change_status({{$store->id}},{{$store->status == 2?1:2}})" type="checkbox" id="status" {{$store->status==1?'checked':''}}>
                                </div>
                            </form>
                        </td>

                        <td>{{$store->parent_id == null?__('admin.no'):__('admin.yes')}}</td>
                        <td>@if($store->parent_id != null){{get_local_name($store->name_ar,$store->name_en)}}@else {{'null'}}@endif</td>
                        <td style="vertical-align: middle;display:flex;justify-content: space-between;">


                            <a href="{{url('admin/stores/show',$store->id)}}" style="font-size: 20px;"><i class="far fa-eye"></i></a>
                            <a type="button" href="{{url('admin/store/update_plan',$store->id)}}" id="store_info" style="font-size: 20px;">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h5 class="text-center">{{__('chef.no_records')}}</h5>
        @endif
    </div>
</div>
<!-- Button trigger modal -->
<button style="display: none;" type="button" id="store_info" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

<!-- info Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('admin.store_details')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="store_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
@include('admin.dashboard.jscript.dashboard')
@endsection