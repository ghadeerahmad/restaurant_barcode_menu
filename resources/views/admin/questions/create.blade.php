@extends('layouts.admin')
@section('title',__('questions.questions'))
@section('css')
<script src="//cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
@endsection
@section('content')
<div class="container col-md-11 shadow-lg">
    <form action="{{url('admin/questions/create')}}" method="POST">
        @csrf
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
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="question_ar" value="{{old('question_ar')}}" id="floatingInput" placeholder="{{__('questions.question_ar')}}">
                    <label for="floatingInput">{{__('questions.question_ar')}}</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('questions.answer_ar')}}</label>
                    <textarea name="answer_ar" id="editor1">{{old('answer_ar')}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="question_en" value="{{old('question_en')}}" id="floatingInput" placeholder="{{__('questions.question_en')}}">
                    <label for="floatingInput">{{__('questions.question_en')}}</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('questions.answer_en')}}</label>
                    <textarea name="answer_en" id="editor2">{{old('answer_en')}}</textarea>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('questions.save')}}</button>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    // Replace the <textarea id="editor1"> with a CKEditor 4
    // instance, using default configuration.
    CKEDITOR.replace('editor1',{
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    CKEDITOR.replace('editor2',{
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection