@include('layout.navbar')
@if ($errors->any())
    @foreach ($errors->all() as $error)
    <p class="text-danger">{{$error}}</p>
    @endforeach
@endif
<form action="{{ route('race.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Race name</label>
        <input type="text" class="form-control" id="name" aria-describedby="name" name="raceName">
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Race date</label>
        <input type="date" class="form-control" id="date" name="date">
    </div>

    <div class="mb-3">
        <label for="formFile" class="form-label">CSV results file</label>
        <input class="form-control" type="file" name="file" id="formFile">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@extends('layout.footer')