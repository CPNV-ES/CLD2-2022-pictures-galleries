@extends('layouts.app')

@section('content')
<h2><?= $picture->title ?></h2>

<img src="{{ route('galleries.pictures.show', [$gallery, $picture]) }}">
@endsection
