@extends('layouts.app')

@section('content')
@include('controls.breadcrumb')
<ul class="collection">
	<li class="collection-item avatar directory-row" id="back_row" data-dir-id="{{$directory->parent_id}}">
		<i class="material-icons circle">replay</i>
		<span class="title unselectable">Back</span>
	</li>
	@foreach ($directory->directories as $subDir)
	    @include('controls.directory-row', ['directory' => $subDir])
	@endforeach
	@foreach ($directory->files as $file)
	    @include('controls.file-row', ['file' => $file])
	@endforeach
</ul>
@include('controls.share-folder')
@include('controls.share-file')
@endsection

@section('scripts')
@parent
<script type="text/javascript">
	$('<input>').attr({
	    type: 'hidden',
	    id: 'parent_id',
	    name: 'parent_id',
	    value: {{$directory->id}}
	}).appendTo('#create_directory_form');

	$('#back_row').on('click', function(){
		$(this).addClass('active');
	});

	$('#back_row').dblclick(function(){
		window.history.back();
	});

	$('#back_row').on('tap', function(){
		if($(window).width() < 991){
			var dirId = $(this).data('dirId');
			window.location="/directory/"+dirId;
		}
	});
</script>
@stop
