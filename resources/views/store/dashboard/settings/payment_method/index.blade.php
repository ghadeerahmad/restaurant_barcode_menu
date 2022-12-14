<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </head>

  <body>
    
     <div class="container mt-3">    
         <table class="table table-hover">
             <thead>
                 <tr>
                     <th>{{__('chef.title_ar')}}</th>
                     <th>{{__('chef.title_en')}}</th>
                     <th>{{__('chef.description_ar')}}</th>
                     <th>{{__('chef.description_en')}}</th>
                     <th>{{__('chef.account_number')}}</th>
                     <th>{{__('chef.payment_image')}}</th>
                     <th>{{__('chef.is_active')}}</th>
                     <th>{{__('chef.actions')}}</th>
                     
                 </tr>
             </thead>
             <tbody>
                 @foreach($store_payment_methods as $value)
                  <tr>
                     <td>{{$value->title_ar}}</td>
                     <td>{{$value->title_en}}</td>
                     <td>{{$value->description_ar}}</td>
                     <td>{{$value->description_en}}</td>
                     <td>{{$value->account_number}}</td>
                     
                     <td><img height ="50px" src ="@if($value->image != null) {{ asset('storage/'.$value->image) }} @endif"></td>

                     <td><span class="badge {{$value->is_active==1?'bg-success':'bg-danger'}}">{{$value->is_active==1?'Active':'Disabled'}}</span></td>
                     <td>
                         <a href="{{url('store/edit_payment_method',$value->id)}}" data-toggle="tooltip" data-original-title="Edit ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                   <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                   <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                             </svg>
                          </a>
                          <a href="#" onclick="if(confirm('Are you sure you want to delete this Payment Method?')){ event.preventDefault();document.getElementById('delete-product-{{$value->id}}').submit(); }" data-toggle="tooltip" data-original-title="Delete">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                 <polyline points="3 6 5 6 21 6"></polyline>
                                 <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                 <line x1="10" y1="11" x2="10" y2="17"></line>
                                 <line x1="14" y1="11" x2="14" y2="17"></line>
                              </svg>
                          </a>
                          <form method="post" action="{{url('store/delete_payment_method',$value->id)}}" id="delete-product-{{$value->id}}" style="display: none">
                             @csrf
                             @method('DELETE')
                          </form>
                     </td>
                  </tr>
                  @endforeach
             </tbody>
         </table>
     </div>
     <div class="d-grid gap-2 col-6 mx-auto">
           <a type="button"class="btn btn-primary" href="{{url('store/add_payment_method')}}">{{__('chef.add_payment_method')}}</a>
     </div>
  </body>
</html>
