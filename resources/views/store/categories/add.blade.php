@extends('layouts.storeAdmin')
@section('title',__('chef.add_category'))
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
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

    .modal {
        z-index: 9999999;
    }

    .modal-lg {
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
<div id="main">
    <div class="container col-md-5 shadow">
        <div class="form-container">
            <div class="form-form container">
                <div class="form-form-wrap" style="width: 100%;">
                    <div class="form-container">
                        <div class="form-content">
                            <form method="POST" action="{{url('store/categories/add')}}">
                                <div class="form">
                                    @csrf
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
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
                                    @switch($store->lang_code) 
                                    @case('ar')
                                    <div class="mb-3">
                                        <label class="form-label">{{__('chef.category_name_ar')}} </label>
                                        <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')}}">
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @break
                                    @case('en')
                                    <div class="mb-3">
                                        <label class="form-label">{{__('chef.category_name_en')}} </label>
                                        <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @break
                                    @default
                                    <div class="mb-3">
                                        <label class="form-label">{{__('chef.category_name_ar')}} </label>
                                        <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')}}">
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{__('chef.category_name_en')}} </label>
                                        <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @endswitch
                                    <div class="mb-3">
                                        <label class="form-label">{{__('chef.isactive')}}</label>
                                        <select class="form-control" name="is_active">
                                            <option value="1">{{__('chef.yes')}}</option>
                                            <option value="0">{{__('chef.no')}}</option>
                                        </select>
                                        @error('is_active')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" id="logo" name="image" value="{{old('image')}}">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-4">&nbsp;</div>
                                            <div class="col-md-4">
                                                <div class="image_area">
                                                    <form method="post">
                                                        <label for="upload_image">
                                                            <img src="@if(old('image') != null) {{ old('image') }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" />

                                                            <input type="file" name="logo" class="image" id="upload_image" style="display:none" />
                                                        </label>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <button class="btn btn-primary" type="submit">{{__('chef.save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        $(document).ready(function() {

            var $modal = $('#modal');

            var image = document.getElementById('sample_image');

            var cropper;

            $('#upload_image').change(function(event) {
                var files = event.target.files;

                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };

                if (files && files.length > 0) {
                    reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 500,
                    height: 500
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $.ajax({
                            url: '{{url("store/uploadImage")}}',
                            method: 'POST',
                            data: {
                                image: base64data,
                                _token: ' <?php echo csrf_token() ?>'
                            },
                            success: function(data) {
                                $modal.modal('hide');
                                $('#uploaded_image').attr('src', '{{asset("storage")}}' + data);
                                $("#logo").attr('value', data);
                            }
                        });
                    };
                });
            });

        });
    </script>

    @endsection