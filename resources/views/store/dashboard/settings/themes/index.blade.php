<div class="container">
    <div class="text-right">
        <a type="button" href="{{url('store/themes/create')}}" class="btn btn-primary">{{__('themes.create')}}</a>
    </div>
    @if(count($themes) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>NO.</th>
                <th>{{__('themes.name')}}</th>
                <th>{{__('themes.is_default')}}</th>
                <th>{{__('themes.is_active')}}</th>
                <th>{{__('themes.actions')}}</th>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach($themes as $value)
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->name}}</td>
                    <td><span class="badge bg-{{$value->is_default==1?'success':'secondary'}}">{{$value->is_default==1?__('themes.default'):__('themes.not_default')}}</span></td>

                    <td>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" onchange="activate({{$value->id}})" value="option1"  {{$store->active_theme_id==$value->id?'checked':''}}>
                    
                    </div>
                    </td>

                    <td>
                        @if($value->store_id == $store->id)
                        <a href="{{url('store/themes/update',$value->id)}}"><i class="fa fa-edit" style="font-size: 20px;"></i></a>
                        <a type="button" href="#"><i class="fa fa-trash-alt" style="font-size: 20px;" onclick="if(confirm('are you sure you want to delete theme?'))document.getElementById('delete-{{$value->id}}').submit()"></i></a>
                        <form action="{{url('store/themes/delete',$value->id)}}" method="POST" id="delete-{{$value->id}}">
                            @csrf
                            @method("DELETE")
                        </form>
                        @endif
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