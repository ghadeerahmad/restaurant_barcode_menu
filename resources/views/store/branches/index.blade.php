@extends('layouts.storeAdmin')
@section('title',__('branches.branches'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <h4 class="text-right">
            <a type="button" class="btn btn-primary" href="{{url('/store/branches/add')}}" method="POST">
                {{__('branches.create')}}
            </a>
        </h4>
        @if(count($branches) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{__('branches.name_ar')}}</th>
                    <th>{{__('branches.name_en')}}</th>
                    <th>{{__('branches.created_at')}}</th>
                    <th>{{__('branches.status')}}</th>
                    <th>{{__('branches.actions')}}</th>
                </thead>
                <tbody>
                    @foreach($branches as $value)
                    <tr>
                        <td>{{$value->name_ar}}</td>
                        <td>{{$value->name_en}}</td>
                        <td>{{$value->created_at}}</td>
                        <td><span class="badge {{$value->status==1?'bg-success':'bg-danger'}}">@switch($value->status)@case(0){{__('branches.waiting_approval')}}@break @case(1){{__('branches.active')}}@break @case(2){{__('branches.disabled')}}@break @endswitch</span></td>
                        <td>
                            <a href="{{url('store/branches/update',$value->id)}}" data-toggle="tooltip" data-original-title="Edit ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <a href="#" onclick="if(confirm('Are you sure you want to delete this Branch?')){ event.preventDefault();document.getElementById('delete-form-{{$value->id}}').submit(); }" data-toggle="tooltip" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>

                            <form method="post" action="{{url('store/branches/delete',$value->id)}}" id="delete-form-{{$value->id}}" style="display: none">
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
        @else
        <h4 class="text-center">{{__('branches.no_branches')}}</h4>
        @endif
    </div>
</section>
@endsection