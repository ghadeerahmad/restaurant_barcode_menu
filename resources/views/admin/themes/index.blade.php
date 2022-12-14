@extends('layouts.admin')
@section('title',__('themes.themes'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <div class="text-right">
        <a type="button" href="{{url('admin/themes/create')}}" class="btn btn-primary">{{__('themes.create')}}</a>
    </div>
    @if(count($themes) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>NO.</th>
                <th>{{__('themes.name')}}</th>
                <th>{{__('themes.is_default')}}</th>
                <th>{{__('themes.store')}}</th>
                <th>{{__('themes.actions')}}</th>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach($themes as $value)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->name}}</td>
                    <td><span class="badge bg-{{$value->is_default==1?'success':'secondary'}}">{{$value->is_default==1?__('themes.active'):__('themes.not_active')}}</span></td>
                    <td>{{$value->store_id == null?'NAN':get_local_name($value->store->name_ar,$value->store->name_en)}}</td>
                    <td>
                        <a href="{{url('admin/themes/update',$value->id)}}"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                        <a type="button" href="#"><i class="fa fa-trash-alt" style="font-size: 20px;" onclick="if(confirm('are you sure you want to delete theme?'))document.getElementById('delete-{{$value->id}}').submit()"></i></a>
                        <form action="{{url('admin/themes/delete',$value->id)}}" method="POST" id="delete-{{$value->id}}">
                            @csrf
                            @method("DELETE")
                        </form>
                    </td>
                </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h4 class="text-center">{{__('themes.no_themes')}}</h4>
    @endif
</div>
@endsection