@include('layout.navbar')
@if ($errors->any())
@foreach ($errors->all() as $error)
<p class="text-danger">{{$error}}</p>
@endforeach
@endif
<form action="{{ route('race.csv', ['race' => $race->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <h1 class="text-center">{{$race->raceName}}</h1>
    <h3 class="text-center">Please add the csv file for the race or delete the race</h3>

    <div class="mb-3">
        <label for="formFile" class="form-label">CSV results file</label>
        <input class="form-control" type="file" name="file" id="formFile">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<form action="{{ route('race.destroy', ['race' => $race->id]) }}" method="post">
    @method('delete')
    @csrf
    <button type="submit" class="btn btn-danger" style="position:absolute; top:10%;right:10%">Delete race</button>
</form>
@extends('layout.footer')