@extends('layouts.app')

@section('content')
<form class="s3upload" action="{{ route('galleries.pictures.store', $gallery) }}" enctype="multipart/form-data" method="POST"
 data-s3attributes="{{ json_encode($postObject->getFormAttributes()) }}"
 data-s3inputs="{{ json_encode($postObject->getFormInputs()) }}"
>
    @csrf
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title"><br>
    <input type="hidden" name="path" value="{{ $path }}">
    <label  for="picture_file">
        picture
      </label>
      <br>
      <input id="picture_file" name="picture_file" type="file"><br>
    <input type="submit" value="Ajout picture">
</form> 
<script src="{{ asset('js/s3upload.js') }}"></script>
@endsection