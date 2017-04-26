@extends('layouts.app')

@section('content')
@include('controls.breadcrumb')
<table class="responsive">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Name</th>
				<th>Last modified</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@if(count($arrDirectories) > 0)
				@foreach ($arrDirectories as $subDir)
				    @include('controls.directory-row', ['directory' => $subDir['dir'], 'is_creator' => $subDir['is_creator']])
				@endforeach
			@endif
			@if(count($arrFiles) > 0)
				@foreach ($arrFiles as $file)
				    @include('controls.file-row', ['file' => $file['file'], 'is_creator' => $file['is_creator']])
				@endforeach
			@endif
			<tr class="avatar directory-row"id="back_row" data-dir-id="{{$mainDir->parent_id}}">
				<td class="center" style="width: 32px;">
					<i class="material-icons circle">replay</i>
				</td>
				<td>
					<span class="title unselectable">Back</span>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
@include('controls.share-folder')
@include('controls.share-file')
@include('controls.edit-file')
@include('controls.edit-directory')
@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('<input>').attr({
	    type: 'hidden',
	    id: 'parent_id',
	    name: 'parent_id',
	    value: {{$mainDir->id}}
	}).appendTo('#create_directory_form');

	$('#back_row').on('click', function(){
		$(this).addClass('active');
	});

	$('#back_row').dblclick(function(){
		window.history.back();
	});
</script>
@stop
