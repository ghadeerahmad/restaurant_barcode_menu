@extends('layouts.admin')
@section('title',__('messages.questions'))
@section('content')
<div class="container col-md-11 shadow-lg">
    <div style="text-align: end;">
        <a type="button" href="{{url('admin/questions/create')}}" class="btn btn-primary">{{__('questions.add_question')}}</a>
    </div>
    @if(count($questions) > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <th>{{__('questions.question')}}</th>
                <th>{{__('questions.created_at')}}</th>
                <th>{{__('questions.actions')}}</th>
            </thead>
            <tbody>
                @foreach($questions as $value)
                <tr>
                    <td>{{get_local_name($value->question_ar,$value->question_en)}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>
                    <a class="btn btn-primary" href="{{url('admin/questions/update',$value->id)}}"><i class="fas fa-edit" style="font-size: 20px;"></i></a>
                    <form action="{{url('admin/questions/delete',$value->id)}}"  method="POST" style="display:inline-block">
                    @csrf    
                    @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
                        </button>
                    </form>  
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h3 class="text-center">{{__('questions.no_data')}}</h3>
    @endif
</div>
@endsection