
<div class="container">
    <form method="POST" action="{{url('store/settings/update_days')}}">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('success'))
        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
                {{session()->get('success')}}
            </div>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.saturday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" value="{{count($work_days)>0?$work_days[0]->opening_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" value="{{count($work_days)>0?$work_days[0]->closing_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0){{$work_days[0]->is_off==0?'selected':''}} @endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0){{$work_days[0]->is_off==1?'selected':''}} @endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.sunday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" value="{{count($work_days)>0?$work_days[1]->opening_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" value="{{count($work_days)>0?$work_days[1]->closing_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0){{$work_days[1]->is_off==0?'selected':''}}@endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0){{$work_days[1]->is_off==1?'selected':''}}@endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.monday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" value="{{count($work_days)>0?$work_days[2]->opening_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" value="{{count($work_days)>0?$work_days[2]->closing_time:''}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0){{$work_days[2]->is_off==0?'selected':''}}@endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0){{$work_days[2]->is_off==1?'selected':''}}@endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.tuesday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" @if(count($work_days) > 0) value="{{$work_days[3]->opening_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                            <input type="time" class="form-control" name="closing_time[]" @if(count($work_days) > 0) value="{{$work_days[3]->closing_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0){{$work_days[3]->is_off==0?'selected':''}}@endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0){{$work_days[3]->is_off==1?'selected':''}}@endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.wednesday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" @if(count($work_days) > 0) value="{{$work_days[4]->opening_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" @if(count($work_days) > 0) value="{{$work_days[4]->closing_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0) {{$work_days[4]->is_off==0?'selected':''}} @endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0) {{$work_days[4]->is_off==1?'selected':''}} @endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.thursday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" @if(count($work_days)>0) value="{{$work_days[5]->opening_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" @if(count($work_days)>0) value="{{$work_days[5]->closing_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0){{$work_days[5]->is_off==0?'selected':''}} @endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0){{$work_days[5]->is_off==1?'selected':''}} @endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">{{__('days.friday')}}</label>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.opening_time')}}</label>
                    <input type="time" class="form-control" name="opening_time[]" @if(count($work_days) > 0) value="{{$work_days[6]->opening_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.closing_time')}}</label>
                    <input type="time" class="form-control" name="closing_time[]" @if(count($work_days) > 0) value="{{$work_days[6]->closing_time}}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{__('days.is_off')}}</label>
                    <select class="form-select" name="is_off[]">
                        <option value="0" @if(count($work_days) > 0) {{$work_days[6]->is_off == 0?'selected':''}} @endif>{{__('chef.no')}}</option>
                        <option value="1" @if(count($work_days) > 0) {{$work_days[6]->is_off == 1?'selected':''}} @endif>{{__('chef.yes')}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('days.save')}}</button>
        </div>
    </form>
</div>