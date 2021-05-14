@extends('layout')

@section('head')
    Edit Album
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('albums.update', $album->id) }}" method="post" class="form-inline">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col">
                <div class="form-group ">
                    <label for="artist" class="sr-only">Artist</label>
                    <select class="form-control" id="artist" name="artist" required data-live-search="true" >
                        <option value=""> --Select Artist-- </option>
                         @foreach ($artists as $key['0'] => $value)
                               <option value="{{ $value['0']['id']}}" {{($value['0']['id']==$album->artist_id)?'selected':''}}>{{ $value['0']['name'] }} </option>
                         @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="albumName" class="sr-only">Album Name</label>
                    <input type="text" class="form-control" name="albumName" id="albumName" pattern=".{3,150}" required title="2 characters minimum" value="{{$album->album_name}}">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="year" class="sr-only">Year</label>
                    <input type="number" class="form-control" name="year" id="year" required min="1000" max="2021" value="{{$album->year}}">
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-2">Save</button>

    </div>
    </form>

@endsection
