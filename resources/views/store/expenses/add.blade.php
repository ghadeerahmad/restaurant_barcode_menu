@extends('layouts.storeAdmin')
@section('title',__('expenses.add_expense'))
@section('content')
<section id="main">
    <div class="container col-md-11 shadow-lg">
        <form method="POST" action="{{url('store/expenses/add')}}" enctype="multipart/form-data">
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
                    <img src="{{asset('storage/stores/shops.png')}}" width="100%" id="preview">
                    <input type="file" name="image" id="image">
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" id="floatingInput" placeholder="{{__('expenses.name')}}">
                        <label for="floatingInput">{{__('expenses.name')}}</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="ammount" value="{{old('ammount')}}" id="floatingInput" placeholder="{{__('expenses.ammount')}}">
                        <label for="floatingInput">{{__('expenses.ammount')}}</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" name="note" id="floatingInput" placeholder="{{__('expenses.note')}}">{{old('note')}}</textarea>
                <label for="floatingInput">{{__('expenses.note')}}</label>
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('expenses.date')}}</label>
                <input type="date" class="form-control" name="date" value="{{old('date')}}">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary">{{__('expenses.save')}}</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('js')
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function(){
    readURL(this);
});
</script>
@endsection