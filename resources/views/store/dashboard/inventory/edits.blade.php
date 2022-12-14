<div class="table-responsive" style="padding-top: 15px;">
    <table class="table table-hover align-items-center table-flush text-center">
        <thead class="thead-light">

            <tr>
                <th class="text-center">NO.</th>
                @switch($store->lang_code)
                @case('ar')
                <th class="text-center">{{__('edits.name_ar')}}</th>
                @break
                @case('en')
                <th class="text-center">{{__('edits.name_en')}}</th>
                @break
                @default
                <th class="text-center">{{__('edits.name_ar')}}</th>
                <th class="text-center">{{__('edits.name_en')}}</th>
                @endswitch
                <th class="text-center">{{__('chef.actions')}}</th>
            </tr>
        </thead>
        <tbody>



            @php $i=1 @endphp
            @foreach($edits as $value)
            <tr>

                <td>
                    <span class="text-muted">{{ $i++}}</span>
                </td>
                @switch($store->lang_code)
                @case('ar')
                <td>
                    <span class="text-muted">{{$value->name_ar}}</span>
                </td>
                @break
                @case('en')
                <td>
                    <span class="text-muted">{{$value->name_en}}</span>
                </td>
                @break
                @default

                <td>
                    <span class="text-muted">{{$value->name_ar}}</span>
                </td>

                <td>
                    <span class="text-muted">{{$value->name_en}}</span>
                </td>
                @endswitch
                <td>

                    <a href="#" onclick="if(confirm('Are you sure you want to delete this edit?')){ event.preventDefault();document.getElementById('delete-edits-{{$value->id}}').submit(); }" data-toggle="tooltip" data-original-title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>

                    <form method="post" action="{{url('store/edits/delete',$value->id)}}" id="delete-edits-{{$value->id}}" style="display: none">
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