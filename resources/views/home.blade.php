@extends('layouts.app')

@section('content')
<ul class="collection">
  @foreach ($directories as $directory)
    @include('controls.directory-row', ['directory' => $directory])
  @endforeach
</ul>
@endsection
