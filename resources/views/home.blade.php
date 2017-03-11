@extends('layouts.app')

@section('content')

@include('controls.breadcrumb')
	@if(count($directories) > 0 || count($files) > 0)
		<ul class="collection">
			@foreach ($directories as $directory)
				@include('controls.directory-row')
			@endforeach

			@foreach ($files as $file)
				@include('controls.file-row')
			@endforeach





		</ul>

        @include('controls.share-folder')
	@endif
@endsection
