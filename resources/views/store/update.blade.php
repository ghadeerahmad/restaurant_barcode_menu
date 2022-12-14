@extends('layouts.app_layout')
@section('css')
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
		<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
		<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
		<script src="https://unpkg.com/dropzone"></script>
		<script src="https://unpkg.com/cropperjs"></script>
		
		<style>
		.image_area {
		  position: relative;
		}

		img {
		  	display: block;
		  	max-width: 100%;
		}

		.preview {
  			overflow: hidden;
  			width: 160px; 
  			height: 160px;
  			margin: 10px;
  			border: 1px solid red;
		}

		.modal-lg{
  			max-width: 1000px !important;
		}

		.overlay {
		  position: absolute;
		  bottom: 10px;
		  left: 0;
		  right: 0;
		  background-color: rgba(255, 255, 255, 0.5);
		  overflow: hidden;
		  height: 0;
		  transition: .5s ease;
		  width: 100%;
		}

		.image_area:hover .overlay {
		  height: 50%;
		  cursor: pointer;
		}

		.text {
		  color: #333;
		  font-size: 20px;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  -webkit-transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  text-align: center;
		}
		
		</style>
@endsection
@section('content')
<div class="form-container">
        <div class="form-form container">
            <div class="form-form-wrap" style="width: 100%;">
                <div class="form-container">
                    <div class="form-content">
                    <form class="text-left" method="POST" action="{{ route('store.create') }}">
                        @csrf
                        <div class="form">
                                <div class="field-wrapper input">
									<input id="store_name" type="text" placeholder="{{__('auth.store_name')}}" class="form-control" name="store_name" value="{{ old('store_name') }}" required autocomplete="store_name">
                                    @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="field-wrapper input">
									<textarea id="description" placeholder="{{__('auth.store_des')}}" class="form-control" name="description" required autocomplete="description">{{old('description')}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="field-wrapper input">
                                <label class="s-primary">{{__('auth.store_logo')}}</label>    
                                <input id="logo" type="text" hidden class="form-control" name="logo" value="{{ old('logo') }}" required>
                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-4">
					<div class="image_area">
						<form method="post">
							<label for="upload_image">
								<img src="@if(old('logo') != null) {{ old('logo') }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" />
								
								<input type="file" name="image" class="image" id="upload_image" style="display:none" />
							</label>
						</form>
					</div>
			    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<h5 class="modal-title">{{__('chef.crop_image')}}</h5>
			        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          			<span aria-hidden="true">×</span>
			        		</button>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview"></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="button" id="crop" class="btn btn-primary">{{__('chef.crop')}}</button>
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('chef.cancel')}}</button>
			      		</div>
			    	</div>
			  	</div>
			</div>	
@endsection
@section('js')

<script>

$(document).ready(function(){

	var $modal = $('#modal');

	var image = document.getElementById('sample_image');

	var cropper;

	$('#upload_image').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			preview:'.preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
	});

	$('#crop').click(function(){
		canvas = cropper.getCroppedCanvas({
			width:500,
			height:500
		});

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){
				var base64data = reader.result;
				$.ajax({
					url:'{{url("store/uploadImage")}}',
					method:'POST',
					data:{image:base64data,_token:' <?php echo csrf_token() ?>'},
					success:function(data)
					{
						$modal.modal('hide');
						$('#uploaded_image').attr('src', data);
                        $("#logo").attr('value',data);
					}
				});
			};
		});
	});
	
});
</script>

@endsection