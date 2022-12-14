@extends('layouts.storeAdmin')
@section('title',__('waiter_call.waiter_calls'))
@section('content')
<div class="container col-lg-11 col-md-11 shadow-lg">
    @if(count($calls) == 0)
    <h4 class="text-center">{{__('waiter_call.no_calls')}}</h4>
    @else
    <table class="table-responsive">
        <table class="table">
            <thead>
                <th>{{__('waiter_call.table')}}</th>
                <th>{{__('waiter_call.status')}}</th>
                <th>{{__('waiter_call.created_at')}}</th>
                <th>{{__('waiter_call.is_completed')}}</th>
                <th>{{__('waiter_call.actions')}}</th>
            </thead>
            <tbody>
                @foreach($calls as $value)
                <tr>
                    <td>{{$value->table->name}}</td>
                    <td>
                        @switch($value->is_completed)
                        @case(0)
                        <span class="badge bg-secondary">{{__('waiter_call.waiting')}}</span>
                        @break
                        @case(1)
                        <span class="badge bg-success">{{__('waiter_call.completed')}}</span>
                        @break
                        @endswitch
                    </td>
                    <td>{{$value->created_at}}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" onchange="completed({{$value->id}})" id="flexSwitchCheckChecked" {{$value->is_completed==1?'checked':''}}>

                        </div>
                    </td>
                    <td>
                        <a href="#" onclick="if(confirm('delete call?')){document.getElementById('delete-{{$value->id}}').submit();}"><i class="fa fa-trash-alt" style="font-size: 20px;"></i></a>
                        <form id="delete-{{$value->id}}" action="{{url('store/waiter_call/delete',$value->id)}}" method="POST">
                            @csrf
                            @method('DELETE')

                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </table>
    @endif
</div>
<!-- The actual snackbar -->
<div id="snackbar"></div>
@endsection
@section('js')
<script>
    function check() {
        $.ajax({
            url: '{{url("store/check_waiter_call")}}',
            type: "GET",
            success: function(data) {
                console.log(data);
                if (data['message'] == 'success')
                    location.reload();
            }
        });
    }

    function completed(id) {
        $.ajax({
            url: '{{url("store/set_completed")}}',
            type: "POST",
            data: {
                'id': id,
                _token: '<?php echo csrf_token(); ?>'
            },
            success: function(data) {
                console.log(data);
                document.getElementById('snackbar').innerHTML = data['message'];
                showToast();
            }
        });
    }
    $(document).ready(function() {
        setInterval(check, 10000);
    });
</script>
@endsection