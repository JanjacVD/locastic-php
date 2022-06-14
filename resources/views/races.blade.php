@include('layout.navbar')
@if (session('status'))
    <p class="text-success">{{session('status')}}</p>
@endif
    <a href="{{route('race.create')}}" class="btn btn-primary mb-5">Add race</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Race</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($race as $race)
            <tr>
                <th scope="row">{{$race->raceName}}</th>
                <td>{{$race->date}}</td>
                <td>
                    <a href="{{ route('race.show', ['race' => $race->id]) }}" class="btn btn-secondary mb-5">Check race</a>
                    <form action="{{ route('race.destroy', ['race' => $race->id]) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete race</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <th scope="row">No races</th>
            </tr>
            @endforelse
        </tbody>
    </table>
@extends('layout.footer')