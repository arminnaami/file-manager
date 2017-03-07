@extends('layouts.app')

@section('content')

@include('controls.breadcrumb')
	@if(count($directories) > 0 || count($files) > 0)
		<ul class="collection">
			@foreach ($directories as $directory)
				@include('controls.directory-row', ['directory' => $directory])
			@endforeach

			@foreach ($files as $file)
			<li class="collection-item avatar directory-row">
				<i class="material-icons circle">folder</i>
				<span class="title">{{$file->name}}.{{$file->extension}}</span>
			</li>
			@endforeach





		</ul>

        @include('controls.share-folder')
	@endif
@endsection
