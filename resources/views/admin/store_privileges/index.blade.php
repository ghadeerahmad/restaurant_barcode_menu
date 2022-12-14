@extends('layouts.admin')
@section('title',__('admin.store_privileges'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        @if(auth()->user()->hasSiteRole('create_store_privilege'))
        <div class="text-right">
            <a type="button" class="btn btn-primary" href="{{url('admin/stores/privileges/add')}}"><i class="fa fa-add"></i> {{__('admin.add_store_privilege')}}</a>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('admin.privilege_name')}}</th>
                    <th>{{__('admin.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($privileges as $value)
                    <tr>
                        <td>{{App::isLocale('ar')?$value->name_ar:$value->name_en}}</td>
                        <td>
                            <a href="{{url('admin/stores/privileges/update',$value->id)}}" data-toggle="tooltip" data-original-title="Edit ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <a href="#" onclick="if(confirm('Are you sure you want to delete this Privilege?')){ event.preventDefault();document.getElementById('delete-addons-{{$value->id}}').submit(); }" data-toggle="tooltip" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>

                            <form method="post" action="{{url('admin/stores/privileges/delete',$value->id)}}" id="delete-addons-{{$value->id}}" style="display: none">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" value="{{$value->id}}" name="id">
                            </form>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection