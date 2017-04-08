@extends('layouts.app')

@section('content')

@include('controls.breadcrumb')
	@if(count($directories) > 0 || count($files) > 0)
	<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Name</th>
				<th>Last modified</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($directories as $directory)
				@include('controls.directory-row')
			@endforeach
			@foreach ($files as $file)
				@include('controls.file-row')
			@endforeach
		</tbody>
	</table>

        @include('controls.share-folder')
        @include('controls.share-file')
	@endif
@endsection
