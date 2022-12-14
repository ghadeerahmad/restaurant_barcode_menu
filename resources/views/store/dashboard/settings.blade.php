@extends('layouts.storeAdmin')
@section('title',__('chef.settings'))
@section('css')
@include('store.dashboard.widgets.image_crop_css')
@include('store.jscript.map')
@endsection
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <ul class="nav nav-pills nav-fill" id="tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">{{__('chef.store_info')}}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab" aria-controls="theme" aria-selected="true">{{__('chef.theme')}}</button>
            </li>
            <li class="nav-item" role="presentation">
               <button class="nav-link " id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="true">{{__('chef.payment_method')}}</button>
           </li>
           <li class="nav-item" role="presentation">
               <button class="nav-link " id="days-tab" data-bs-toggle="tab" data-bs-target="#days" type="button" role="tab" aria-controls="days" aria-selected="true">{{__('days.week_days')}}</button>
           </li>
           <li class="nav-item" role="presentation">
               <button class="nav-link " id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="days" aria-selected="true">{{__('chef.other_settings')}}</button>
           </li>
        </ul>
        <div class="tab-content" id="tab-content">
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                @include('store.dashboard.settings.info')
            </div>
            <div class="tab-pane fade " id="theme" role="tabpanel" aria-labelledby="theme-tab">
                @include('store.dashboard.settings.themes.index')
            </div>
            <div class="tab-pane fade " id="payment" role="tabpanel" aria-labelledby="payment-tab">
                @include('store.dashboard.settings.payment_method.index')
           </div>
           <div class="tab-pane fade " id="days" role="tabpanel" aria-labelledby="days-tab">
                @include('store.dashboard.settings.week_days')
           </div>
           <div class="tab-pane fade " id="other" role="tabpanel" aria-labelledby="other-tab">
                @include('store.dashboard.settings.other')
           </div>
        </div>
    </div>
</section>

@include('store.dashboard.widgets.image_crop')
@endsection
@section('js')
@include('store.jscript.image_crop')
@include('store.dashboard.settings.scripts.themes')
@include('store.dashboard.settings.scripts.other_settings')
@endsection