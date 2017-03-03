<li class="collection-item avatar directory-row" data-dir-id="{{$directory->id}}" style="display: block;">
	<i class="material-icons circle">folder</i>
	<span class="title">{{$directory->original_name}}</span>
	<div class="fixed-action-btn horizontal click-to-toggle">
		<a class="btn-floating btn-large">
	      	<i class="material-icons">menu</i>
	    </a>
	    <ul>
	      	<li><a class="btn-floating red delete-directory-btn" data-dir-id="{{$directory->id}}"><i class="material-icons">delete_forever</i></a></li>
	      	<li><a href="#share_directory" class="btn-floating blue share-directory-btn" data-dir-id="{{$directory->id}}"><i class="material-icons">share</i></a></li>
	    </ul>
	</div>
</li>
@section('scripts')
	@parent
	<script type="text/javascript">
	$('.directory-row').on('click', function(){
		$('.directory-row').not(this).removeClass('active');
		$(this).addClass('active');
	});

	$('.directory-row').dblclick(function(){
		var dirId = $(this).data('dirId');
		window.location="/directory/"+dirId;
	});
	$('.directory-row').on('tap', function(){
		if($(window).width() < 991){
			var dirId = $(this).data('dirId');
			window.location="/directory/"+dirId;
		}
	});

	$('.delete-directory-btn').on('click', function(){
		var dirId = $(this).data('dirId');
		if(confirm('Are you shure?')){
			window.location="/directory/delete/"+dirId;
		}
		return;
	});
	$('.share-directory-btn').on('click', function(){
		var dirId = $(this).data('dirId');
		$('#share_directory_form').find('#dir_to_share').val(dirId);
	});
	</script>
@endsection
