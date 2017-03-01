<li class="collection-item avatar directory-row" data-dir-id="{{$directory->id}}">
	<i class="material-icons circle">folder</i>
	<span class="title">{{$directory->original_name}}</span>
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
	$('.directory-row').on('tap', function(){alert();});
	</script>
@endsection
