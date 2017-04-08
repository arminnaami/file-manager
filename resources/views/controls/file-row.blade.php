<tr class='avatar file-row' data-file-id="{{$file->id}}">
	<td class="center" style="width :32px;">
		<i class="material-icons circle">photo</i>
	</td>
	<td>
		<span class="title unselectable">{{$file->name}}.{{$file->extension}}</span>
	</td>
	<td>
		{{date('M, d, Y', strtotime($file->updated_at))}}
	</td>
	<td style="position: relative;">
		<div class="fixed-action-btn horizontal click-to-toggle" style="position:static;">
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
			      	<a href="#share_file" class="btn-floating blue share-file-btn" data-file-id="{{$file->id}}">
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
	$('.file-row').on('tap', function(){
		if($(window).width() < 991){
			var fileId = $(this).data('fileId');
			window.location="/file/"+fileId;
		}
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
	</script>
@endsection
