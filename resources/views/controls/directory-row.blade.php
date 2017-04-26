<tr class="avatar directory-row" data-dir-id="{{$directory->id}}">
	<td class="center" style="widows: 32px;">
		<i class="material-icons circle">folder</i>
	</td>
	<td>
		<span class="title unselectable">{{$directory->original_name}}</span>
	</td>
	<td>
		{{date('M, d, Y', strtotime($directory->updated_at))}}
	</td>
	<td style="position: relative;">
		<div class="fixed-action-btn horizontal click-to-toggle right" style="position: static; padding-right: 20px;">
			<a class="btn-floating btn-large">
		      	<i class="material-icons">menu</i>
		    </a>
		    <ul style="top: 80%; right: 70px;">
		      	<li>
			      	<a class="btn-floating red" href="javascript:deleteDirectory('{{$directory->id}}');" data-dir-id="{{$directory->id}}">
			      		<i class="material-icons">delete_forever</i>
			      	</a>
		      	</li>
		      	@if(isset($is_creator) && $is_creator)
			      	<li>
				      	<a href="#rename_dir" class="activate_modal btn-floating yellow rename-directory-btn" data-dir-id="{{$directory->id}}">
				      		<i class="material-icons">edit</i>
				      	</a>
			      	</li>
			      	<li>
				      	<a href="#share_directory" class="activate_modal btn-floating blue share-directory-btn" data-dir-id="{{$directory->id}}">
				      		<i class="material-icons">share</i>
				      	</a>
			      	</li>
		      	@endif
		      	<li>
			      	<a class="btn-floating green lighten-1 download-dir-btn" data-dir-id="{{$directory->id}}">
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
	$('.directory-row').on('click', function(){
		$('.directory-row').not(this).removeClass('active');
		$('.file-row').not(this).removeClass('active');
		$(this).addClass('active');
	});

	$('.directory-row').dblclick(function(){
		var dirId = $(this).data('dirId');
		window.location="/directory/"+dirId;
	});
	function deleteDirectory(dirId){
		if(confirm('Are you shure?')){
			window.location="/directory/delete/"+dirId;
		}
	}
	$('.share-directory-btn').on('click', function(){
		var dirId = $(this).data('dirId');
		$('#share_directory_form').find('#dir_to_share').val(dirId);
	});
	$('.download-dir-btn').on('click', function(){
		var dirId = $(this).data('dirId');
		window.location="/directory/download/"+dirId;
	});

	$('.rename-directory-btn').on('click', function(){
		var dirId = $(this).data('dirId');
		$('#rename_directory_form').find('#dir_to_rename').val(dirId);
	});
	</script>
@endsection
