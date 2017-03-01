@extends('layouts.app')

@section('content')

@include('controls.breadcrumb')
	@if(count($directories) > 0)
		<ul class="collection">
		  @foreach ($directories as $directory)
		    @include('controls.directory-row', ['directory' => $directory])
		  @endforeach
		</ul>
	@endif
@endsection
