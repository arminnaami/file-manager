@extends('layouts.app')
@section('content')

<form class="col s12" role="form" method="POST" action="{{ url('/profile/edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
	<div class="container" id="edit-profile">
		<div class="row">
			<div class="col s6 offset-s3">
				<ul class="collection with-header">
					<li class="collection-header">
						<h4>Profile edit</h4>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>Name</strong>
							</div>
							<div class="col s9 input-field mt0">
								 <input
			                    type="text"
			                    name="name"
			                    id="text"
			                    value="{{ $user->name }}"
			                    class="validate"
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>Email</strong>
							</div>
							<div class="col s9 input-field mt0">
								 <input
			                    type="email"
			                    name="email"
			                    id="text"
			                    value="{{ $user->email }}"
			                    class="validate"
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>Profile picture</strong>
							</div>
							<div class="file-field input-field col s9 mt0">
								<div class="btn">
									<span>File</span>
									<input type="file" name="profile_picture">
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" type="text">
								</div>
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row">
							<div class="col s6 left-align">
								<a href="{{ url('profile') }}" class="btn waves-effect grey">Back</a>
							</div>
							<div class="col s6 right-align">
								<button type="submit" name="btn_save" class="btn waves-effect">Save</button>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
@if ($errors->has('name'))
	Materialize.toast("{{ $errors->first('name') }}", 4000, 'red darken-4');
	$('#name').addClass("invalid");
	$('#name').prop("aria-invalid", "true");
@endif
@if ($errors->has('email'))
	Materialize.toast("{{ $errors->first('email') }}", 4000, 'red darken-4');
	$('#email').addClass("invalid");
	$('#email').prop("aria-invalid", "true");
@endif
</script>
@endsection
