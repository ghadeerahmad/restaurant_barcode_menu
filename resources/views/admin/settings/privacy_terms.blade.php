@extends('layouts.admin')
@section('css')
<script src="//cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
@endsection
@section('content')
<div class="container col-md-11 shadow-lg">
    <form action="{{url('admin/privacy_terms')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.privacy_ar')}}</label>
                    <textarea name="privacy_ar" id="privacy_ar">{!! $settings[0]->value !!}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.privacy_en')}}</label>
                    <textarea name="privacy_en" id="privacy_en">{!! $settings[1]->value !!}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.terms_ar')}}</label>
                    <textarea name="terms_ar" id="terms_ar">{!! $settings[2]->value !!}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.terms_en')}}</label>
                    <textarea name="terms_en" id="terms_en">{!! $settings[3]->value !!}</textarea>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('settings.save')}}</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    
    CKEDITOR.replace('privacy_ar');
    CKEDITOR.replace('privacy_en');
    
    CKEDITOR.replace('terms_ar');
    CKEDITOR.replace('terms_en');
</script>
@endsection