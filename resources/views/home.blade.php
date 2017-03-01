@extends('layouts.app')

@section('content')
	@if(count($directories) > 0)
		<ul class="collection">
		  @foreach ($directories as $directory)
		    @include('controls.directory-row', ['directory' => $directory])
		  @endforeach
		</ul>
	@endif
@endsection
