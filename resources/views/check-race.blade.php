@include('layout.navbar')
@if (session('status'))
<p class="text-success">{{session('status')}}</p>
@endif
<a href="{{route('race.add', ['race' => $race->id]) }}" style="position:absolute; top:10%;right:10%" class="btn btn-success">Import result</a>

<table class="table mb-5">
    <thead>
        <h1 class="text-center pb-5" style="text-transform:capitalize;">{{$race->raceName}} results</h1>
        <h2 class="text-center pb-5" style="text-transform:capitalize;">Race date: {{$race->date}}</h2>
        <h3 class="text-left pb-1" style="text-transform:capitalize;">Distance: medium</h3>
        <h4 class="text-left pb-1" style="text-transform:capitalize;">Avg.time: {{$m}}</h4>

        <tr>
            <th scope="col">Full name</th>
            <th scope="col">Finish time</th>
            <th scope="col">Placement</th>
            <th scope="col"> </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results['medium'] as $res)
        <tr>
            <th scope="col">{{$res->fullName}}</th>
            <th scope="col">{{$res->raceTime}}</th>
            <th scope="col">{{$res->placement}}</th>
            <th scope="col">
                <a href="{{route('race.edit', ['race' => $res->id]) }}" class="btn btn-primary">Edit result</a>
            </th>
        </tr>
        @empty
        <p class="text-center">No results</p>
        @endforelse
    </tbody>
</table>


<table class="table">
    <thead>
        <h3 class="text-left pb-1" style="text-transform:capitalize;">Distance: long</h3>
        <h4 class="text-left pb-1" style="text-transform:capitalize;">Avg.time: {{$l}}</h4>
        <tr>
            <th scope="col">Full name</th>
            <th scope="col">Finish time</th>
            <th scope="col">Placement</th>
            <th scope="col">
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results['long'] as $res)
        <tr>
            <th scope="col">{{$res->fullName}}</th>
            <th scope="col">{{$res->raceTime}}</th>
            <th scope="col">{{$res->placement}}</th>
            <th scope="col">
                <a href="{{route('race.edit', ['race' => $res->id]) }}" class="btn btn-primary">Edit result</a>
            </th>
        </tr>
        @empty
        <p class="text-center">No results</p>
        @endforelse
    </tbody>
</table>
@extends('layout.footer')