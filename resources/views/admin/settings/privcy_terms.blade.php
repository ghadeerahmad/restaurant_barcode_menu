@extends('layouts.admin')
@section('content')
<div class="container col-md-11 shadow-lg">
    <form action="" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.privacy_ar')}}</label>
                    <textarea name="privacy_ar" id="privacy_ar"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.privacy_en')}}</label>
                    <textarea name="privacy_en" id="privacy_en"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.terms_ar')}}</label>
                    <textarea name="terms_ar" id="terms_ar"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{__('settings.terms_en')}}</label>
                    <textarea name="terms_en" id="terms_en"></textarea>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('settings.save')}}</button>
        </div>
    </form>
</div>
@endsection