@extends('layouts.auth')
@section('title',__('auth.login'))
@section('content')

<div class="container col-md-4 shadow-lg" style="padding: 20px 25px;">
    <form class="text-left" method="POST" action="{{ url('/login') }}">
        @csrf
        @error('errors')
        <div class="alert alert-warning d-flex align-items-center alert-dismissible" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div>
            {{$message}}
            </div>
            
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif 
        <div class="form">

            <div class="mb-3">
                <label class="form-label">{{__('chef.email')}}</label>
                <input id="email" type="email" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{__('chef.password')}}</label>
                <input id="password" placeholder="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                @error('password')
                <div class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary" value="">login</button>
            </div>
            <div class="mb-3">
                <p class="text-center">{{__('chef.dont_have_account')}} <a href="{{url('register')}}">{{__('chef.register')}}</a></p>
            </div>


        </div>
    </form>
</div>
</div>
</div>
</div>
</div>
@endsection