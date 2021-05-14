@extends('layout')

@section('head')
Artists & Albums
@endsection


@section('content')

@if (!@empty($message))
    @section('content')
    <div class="alert alert-success">
        {{$message}}
    </div>
@endif

    <a href="{{route('albums.create')}}" class="btn btn-dark mb-2">New</a>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Artist</th>
            <th>Album</th>
            <th>Year</th>
            <th width="200px"></th>
        </tr>

        @foreach($albums as $album)
        <tr>
            <td>{{ $album->artist }}</td>
            <td>{{ $album->album_name }}</td>
            <td>{{ $album->year }}</td>
            <td class="text-center">
                <form method="post" action="/albums/{{$album->id}}" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($album->album_name) }}?')">
                    <a href="{{route('albums.edit',$album->id)}}" class="btn btn-dark ">Update</a>

                    @if(Auth::user()->role == 'admin')
                    @csrf
                    @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    @endif
                </form>
            </td>
        </tr>
        @endforeach

    </table>
@endsection


