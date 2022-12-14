@extends('layouts.auth')
@section('title',__('auth.register'))
@section('content')
<div class="container col-md-7 shadow-lg">
    <div class="form-form container">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @if(session()->has('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif
                        @error('errors')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @endif
                        <div class="form">

                            <div class="mb-3">
                                <label class="form-label">{{__('chef.email')}}</label>
                                <input id="email" type="email" placeholder="{{__('auth.email_field')}}" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{__('chef.password')}}</label>
                                <input id="password" placeholder="{{__('auth.password_field')}}" type="password" class="form-control" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div class="d-sm-flex justify-content-between">
                            <div style="display: inherit;">
                                <p class="d-inline-block">{{__('auth.show_password')}}</p>
                                <div class="form-check form-switch">
                                    <input type="checkbox" id="toggle-password" class="form-check-input" onchange="showHide()">
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <button type="submit" class="btn btn-primary" value="">{{__('auth.register')}}</button>
                            </div>

                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
@section('js')
<script>
    var i=0;
function showHide(){
    if(i==0){
        $("#password").attr('type','text');
        i=1;
    }else{
        $("#password").attr('type','password');
        i=0;
    }
}
</script>
@endsection