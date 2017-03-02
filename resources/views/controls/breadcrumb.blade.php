<nav id="breadcrumb" class="white">
    <div class="nav-wrapper">
      <div class="col s12">
		@if(isset($directory))
			<a href="{{url('home')}}" class="breadcrumb"><span>My Drive</span></a>
			@foreach ($parents as $parent)
	        	<a href="#!" class="breadcrumb back" data-dir-id="{{$parent->id}}"><span>{{ $parent->original_name }}</span></a>
			@endforeach
			<a href="#!" class="breadcrumb"><span class="dropdown-button" data-activates='upload_drpdn'>{{ $directory->original_name }}&#9662;</span></a>
		@else
		 <a class='breadcrumb' href='#'><span class="dropdown-button" data-activates='upload_drpdn'>My Drive&#9662;</span></a>
		@endif
		 <ul id='upload_drpdn' class='dropdown-content'>
            <li><a href="#create_directory"><i class="material-icons">create_new_folder</i>&nbsp;Create new folder</a></li>
            <li class="divider"></li>
            <li><a href="#!"><i class="material-icons">file_upload</i>&nbsp;File upload</a></li>
            <li><a href="#!"><i class="material-icons">folder</i>&nbsp;Folder upload</a></li>
        </ul>
      </div>
    </div>
  </nav>

  @section('scripts')
  @parent
  <script type="text/javascript">

(function($) {
    $(function() {

  	$('.breadcrumb.back').on('click', function(){
  		var dirId = $(this).data('dirId');
  		if(typeof dirId != 'undefined'){
			window.location="/directory/"+dirId;
  		}
	});
	if($('#breadcrumb .nav-wrapper').hasScrollBar()){
		$('#breadcrumb .nav-wrapper > div').scrollLeft($(this).width());
	}
    }); // end of document ready
})(jQuery); // end of jQuery name space
  </script>
  @stop