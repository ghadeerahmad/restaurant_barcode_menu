@extends('layouts.storeAdmin')
@section('content')
<section id="main">
      <div class="container col-md-11 shadow-lg">
          <form action="{{url('store/create_payment_method')}}" method="POST" enctype="multipart/form-data">
               @csrf
               @if($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                         @foreach($errors->all() as $error)
                             <li> {{ $error }} </li>
                         @endforeach
                     </ul>  
                 </div>
               @endif

               @include('store.dashboard.settings.payment_method.widgets.title')
               @include('store.dashboard.settings.payment_method.widgets.description')

               <div class="row">
                  <div class ="col-md-4">
                     <div class="mb-3">
                         <label for ="image">{{__('chef.payment_image')}}</label>
                         <input id="upload" type="file" class="form-control" name="image" value="{{old('image')}}" />
                     </div>
                 </div>
               </div>
               <div class="row">
                 <div class="col-md-4">
                      <div class="form-floating mb-3">
                           <input type="text" class="form-control" id="floatingInput" name="account_number" placeholder="{{__('chef.account_number')}}" value="{{old('account_number')}}">
                            <label for="floatingInput">{{__('chef.account_number')}}</label>                                                                 
                      </div>
                 </div>
                 
                  <div class="mb-3">
                      <div class="form-check form-switch">
                          <input class="form-check-input" name="is_active" type="checkbox" id="flexSwitchCheckDefault" checked>
                           <label class="form-check-label" for="flexSwitchCheckDefault">{{__('chef.is_active')}}</label>
                      </div>
                  </div>
               </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                 <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
             </div>
          </form>
      </div>
</section>
@endsection
