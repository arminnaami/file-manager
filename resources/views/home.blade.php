@extends('layouts.app')

@section('content')
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
				@include('controls.directory-row', ['is_creator' => $is_creator])
			@endforeach
			@foreach ($files as $file)
				@include('controls.file-row', ['is_creator' => $is_creator])
			@endforeach
		</tbody>
	</table>

    @include('controls.share-folder')
    @include('controls.share-file')
    @include('controls.edit-file')
    @include('controls.edit-directory')
@else

	@if($is_creator)
		<div class="container">
			<div class="row">
				<div class="col s12 center">
					<h2>You don't have files</h2>
					<a class='dropdown-button btn btn-thinner mob-no' href='#' data-activates='upload_drpdn_main_nav'>Add new</a>
				    <ul id='upload_drpdn_main_nav' class='dropdown-content'>
				        <li><a href="#create_directory" class="activate_modal"><i class="material-icons">create_new_folder</i>&nbsp;Create new folder</a></li>
				        <li class="divider"></li>
				        <li><a href="#upload_file" class="activate_modal"><i class="material-icons">file_upload</i>&nbsp;File upload</a></li>
				    </ul>
				</div>
			</div>
		</div>
	@endif
@endif
@endsection
