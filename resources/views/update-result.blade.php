@include('layout.navbar')
@if ($errors->any())
    @foreach ($errors->all() as $error)
    <p class="text-danger">{{$error}}</p>
    @endforeach
@endif
<form action="{{ route('race.update', ['race' => $result->id])}}" method="POST">
    @method('put')
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Full name</label>
        <input type="text" class="form-control" id="name" aria-describedby="name" name="fullName" value="{{$result->fullName}}">
    </div>

    <div class="mb-3">
        <label for="time" class="form-label">Time</label>
        <input type="time" step="1" class="form-control" id="time" name="raceTime" value="{{$result->raceTime}}">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@extends('layout.footer')