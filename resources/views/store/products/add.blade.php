@extends('layouts.storeAdmin')
@section('title',__('chef.add_product'))
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
</style>
@endsection
@section('content')
<div id="main">
    <div class="container shadow-lg">
        <form action="{{url('store/products/add')}}" method="POST" role="form">
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
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">{{__('chef.product_image')}} (500x500)</label>
                    <input type="hidden" id="logo" name="image" value="{{old('image')}}">
                    <div class="image_area">
                        
                            <label for="upload_image">
                                <img src="@if(old('image') != null) {{ asset('storage'.old('image')) }} @else {{asset('storage/stores/shops.png')}} @endif" id="uploaded_image" class="img-responsive img-circle" width="100%" />

                                <input type="file" name="logo" class="image" id="upload_image" style="display:none" />
                            </label>
                        
                    </div>
                </div>
                <div class="col-md-10">
                    @include('store.products.widgets.product_name')

                </div>
            </div>
                <div class="input-group mb-3">
                <input type="number" class="form-control" name="price" placeholder="{{__('chef.price')}}" value="{{old('price')}}">

                <span class="input-group-text" id="basic-addon1">{{$currency->code}}</span>

            </div>
            <div class="mb-3">
                <label class="form-label">{{__('chef.category')}}</label>
                <select class="selectpicker form-control" name="product_category_id" data-live-search="true" style="height: 200px">
                    @foreach($cates as $cat)
                    <option value="{{ $cat->id }}">{{ get_local_name($cat->name_ar,$cat->name_en) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('chef.is_active')}}</label>
                <select class="form-select" name="is_active">
                    <option value="1">{{__('chef.yes')}}</option>
                    <option value="0">{{__('chef.no')}}</option>
                </select>
            </div>

            @include('store.products.widgets.product_description')
            <div class="row">
                <!-- <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.is_recommended')}}</label>
                        <select class="selectpicker form-control" name="is_recommended">

                            <option value="0">{{ __('chef.no') }}</option>
                            <option value="1">{{ __('chef.yes') }}</option>
                        </select>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.addons')}}</label>
                        <select class="selectpicker form-control" name="addons[]" multiple="multiple" data-live-search="true" style="height: 200px">
                            @foreach($addons as $addon)
                            <option value="{{ $addon->id }}">{{ get_local_name($addon->name_ar,$addon->name_en) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.edits')}}</label>
                        <select class="selectpicker form-control" name="edits[]" multiple="multiple" data-live-search="true" style="height: 200px">
                            @foreach($edits as $edit)
                            <option value="{{ $edit->id }}">{{ get_local_name($edit->name_ar,$edit->name_en) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.sauces')}}</label>
                        <select class="selectpicker form-control" name="sauces[]" multiple="multiple" data-live-search="true" style="height: 200px">
                            @foreach($sauces as $sauce)
                            <option value="{{ $sauce->id }}">{{ get_local_name($sauce->name_ar,$sauce->name_en) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.discount')}}</label>
                        <input type="number" class="form-control" name="discount" value="{{old('discount')}}">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.discount_type')}}</label>
                        <select class="selectpicker form-control" name="discount_type">
                            <option value="AMOUNT">{{__('chef.amount')}}</option>
                            <option value="PERCENT">{{__('chef.percent')}}</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.cooking_time')}}</label>
                        <input type="number" class="form-control" name="cooking_time" value="{{old('cooking_time')}}">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">{{__('chef.size_available')}}</label>
                        <select class="selectpicker form-control" name="sizes[]" multiple="multiple" data-live-search="true">
                            @foreach($sizes as $size)
                            <option value="{{$size->id}}">{{get_local_name($size->name_ar,$size->name_en)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" name="submit" class="btn btn-primary" value="{{__('chef.save')}}" />
            </div>
        </form>
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