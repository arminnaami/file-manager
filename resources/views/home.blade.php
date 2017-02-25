@extends('layouts.app')

@section('content')
<ul class="collection">
  @foreach ($user->directories as $directory)
    @include('controls.directory-row', ['directory' => $directory])
  @endforeach
</ul>
@endsection
