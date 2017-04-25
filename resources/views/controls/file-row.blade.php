<tr class='avatar file-row' data-file-id="{{$file->id}}">
	<td class="center" style="width :32px;">
		<svg class="icon"  style="width: 32px; height:32px;">
			<use xlink:href="{{ URL::asset('/img/file_extensions.svg') }}
			@if ($file->extensionIcon != null)
				{{$file->extensionIcon->icon_id}}
			@else
				#file
			@endif
			"></use>
		</svg>
	</td>
	<td>
		<span class="title unselectable">{{$file->name}}.{{$file->extension}}</span>
	</td>
	<td>
		{{date('M, d, Y', strtotime($file->updated_at))}}
	</td>
	<td style="position: relative;">
		<div class="fixed-action-btn horizontal right click-to-toggle" style="position:static; padding-right: 20px;">
			<a class="btn-floating btn-large">
		      	<i class="material-icons">menu</i>
		    </a>
		    <ul style="top: 80%; right: 70px;">
		      	<li>
			      	<a class="btn-floating red" href="javascript:deleteFile('{{$file->id}}');" data-file-id="{{$file->id}}">
			      		<i class="material-icons">delete_forever</i>
			      	</a>
		      	</li>
		      	<li>
			      	<a href="#rename_file" class="activate_modal btn-floating yellow rename-file-btn" data-file-id="{{$file->id}}">
			      		<i class="material-icons">edit</i>
			      	</a>
		      	</li>
		      	<li>
			      	<a href="#share_file" class="activate_modal btn-floating blue share-file-btn" data-file-id="{{$file->id}}">
			      		<i class="material-icons">share</i>
			      	</a>
		      	</li>
		    	<li>
			    	<a class="btn-floating green lighten-1 download-file-btn" data-file-id="{{$file->id}}">
			    		<i class="material-icons">file_download</i>
			    	</a>
		    	</li>
		    </ul>
		</div>
	</td>
</tr>
@section('scripts')
	@parent
	<script type="text/javascript">
	$('.file-row').on('click', function(){
		$('.file-row').not(this).removeClass('active');
		$('.directory-row').not(this).removeClass('active');
		$(this).addClass('active');
	});

	$('.file-row').dblclick(function(){
		var fileId = $(this).data('fileId');
		window.location="/file/"+fileId;
	});
	$('.download-file-btn').on('click', function(){
		var fileId = $(this).data('fileId');
		window.location="/file/"+fileId;
	});
	function deleteFile(fileId){
		if(confirm('Are you shure?')){
			window.location="/file/delete/"+fileId;
		}
	}
	$('.share-file-btn').on('click', function(){
		var fileId = $(this).data('fileId');
		$('#share_file_form').find('#file_to_share').val(fileId);
	});
	$('.rename-file-btn').on('click', function(){
		var fileId = $(this).data('fileId');
		$('#rename_file_form').find('#file_to_rename').val(fileId);
	});
	</script>
@endsection
