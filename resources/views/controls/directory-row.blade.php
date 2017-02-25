<li class="collection-item avatar directory-row">
	<i class="material-icons circle">folder</i>
	<span class="title">{{$directory->name}}</span>
</li>
@section('scripts')
	<script type="text/javascript">
	$('.directory-row').on('click', function(){
		$('.directory-row').not(this).removeClass('active');
		$(this).addClass('active');
	});
	</script>
@endsection
