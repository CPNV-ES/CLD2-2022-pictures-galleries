@extends('layouts.app')

@section('content')
<a href="{{ route('galleries.pictures.create', $gallery) }}">Add new  picture</a>

<table>
    <thead>
        <th>Name</th>
        <th>Image</th>
    </thead>
    <tbody>
        @foreach ($pictures as $picture)
            <tr>
                <td>{{ $picture->title }} </td>
                <td><img src="{{ route('galleries.pictures.show', [$gallery, $picture]) }}" width="50" height="60"></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection




