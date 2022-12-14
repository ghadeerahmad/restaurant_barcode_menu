@extends('layouts.storeAdmin')
@section('content')
      <div class="container col-md-11 shadow-lg">
          <form action="{{url('store/update_payment_method' , $store_payment_method->id)}}" method="POST" enctype="multipart/form-data">
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

                     <div class="mb-3">
                         <label for ="image">{{__('chef.payment_image')}}</label>
                         <input id="upload" type="file" class="form-control" name="image" />
                     </div>
                

                      <div class="form-floating mb-3">
                           <input type="text" class="form-control" id="floatingInput" name="account_number" placeholder="{{__('chef.account_number')}}"  value="{{$store_payment_method->account_number}}">
                            <label for="floatingInput">{{__('chef.account_number')}}</label>                                                                                                                        
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
@endsection