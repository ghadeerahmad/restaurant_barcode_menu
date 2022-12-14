@extends('layouts.storeAdmin')
@section('title',__('tables.tables'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <div class="container text-right">
            <a href="{{url('store/tables/add')}}" type="link" class="btn btn-primary"><i class="fa fa-plus"></i> {{__('tables.add')}}</a>
        </div>
        @if(count($tables) > 0)
        <div class="row">
        @foreach($tables as $table)
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
            <h3>{{$table->name}}</h3></div>
                <div class="card-body">
            <p>{{__('tables.number')}}: {{$table->code}} <span class="badge {{$table->is_active==1?'bg-success':'bg-danger'}}">{{$table->is_active==1?__('tables.active'):__('tables.disabled')}}</span></p>
           
            <div class="text-center">
                <a type="button" href="{{url('store/tables/print_qr',$table->id)}}" class="btn btn-primary">{{__('tables.print_qr')}}</a>
                <form method="post" action="{{url('store/tables/delete',$table->id)}}" style="display: inline-block">
                                                                @csrf
                                                                @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                                            </form>
            </div>        
        </div></div></div>
        @endforeach
        </div>
        @else
        <h3 class="text-center">{{__('tables.no_tables')}}</h3>
        @endif
    </div>
</section>
@endsection