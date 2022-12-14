<div class="container">
 <form action="{{url('store/create_theme')}}" method="POST" enctype="multipart/form-data">
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
    <div class="row">
       <div class="col-md-4">
          <div class="mb-3">
             <label for="primary_color" class="form-label">{{__('chef.primary_color')}}</label>
             <input type="color" class="form-control form-control-color" id="primary_color" value="#000" title="Choose your color" name ="primary_color">
          </div>
       </div>
       <div class="col-md-4">
          <div class="mb-3">
             <label for="secondary_color" class="form-label">{{__('chef.secondary_color')}}</label>
             <input type="color" class="form-control form-control-color" id="secondary_color" value="#000" title="Choose your color" name ="secondary_color">
          </div>
       </div>
       <div class="col-md-4">
          <div class="mb-3">
             <label for="text_color" class="form-label">{{__('chef.text_color')}}</label>
             <input type="color" class="form-control form-control-color" id="text_color" value="#000" title="Choose your color" name ="text_color">
          </div>
       </div>
    </div>
    <div class="row">
       <div class ="col-md-4">
          <label for ="background_image">{{__('chef.background_image')}}</label>
          <input id="upload" type="file" class="form-control" name="background_image" />
      </div>
    </div>
    <div class="row">
       <div class ="col-md-4">
          <label for ="fav_icon">{{__('chef.fav_icon')}}</label>
          <input id="upload" type="file" class="form-control" name="fav_icon" />
      </div>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto">
            <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
        </div>
 </form>
</div>