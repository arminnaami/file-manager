@extends('app')
@section('content')

<form id="change_password_form" class="col s12" role="form" method="POST" action="{{ url('/profile/change-password') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
	<div class="container" id="edit-profile">
		<div class="row">
			<div class="col s12">
				<ul class="collection with-header">
					<li class="collection-header">
						<h4>Change password</h4>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>Old password</strong>
							</div>
							<div class="col s9 input-field mt0">
								 <input
			                    type="password"
			                    name="password"
			                    id="password"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>Confirm old password</strong>
							</div>
							<div class="col s9 input-field mt0">
								 <input
			                    type="password"
			                    name="password_confirmation"
			                    id="password_confirmation"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s3">
								<strong>New password</strong>
							</div>
							<div class="col s9 input-field mt0">
								 <input
			                    type="password"
			                    name="new_password"
			                    id="new_password"
			                    class="validate"
			                    required
			                    >
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
@parent
<script type="text/javascript">
@if ($errors->has('password'))
        Materialize.toast("{{ $errors->first('password') }}", 4000, 'red darken-4');
        $('#password').addClass("invalid");
        $('#password').prop("aria-invalid", "true");
    @endif
    @if ($errors->has('password_confirmation'))
        Materialize.toast("{{ $errors->first('password_confirmation') }}", 4000, 'red darken-4');
        $('#password_confirmation').addClass("invalid");
        $('#password_confirmation').prop("aria-invalid", "true");
    @endif
    @if ($errors->has('new_password'))
        Materialize.toast("{{ $errors->first('new_password') }}", 4000, 'red darken-4');
        $('#new_password').addClass("invalid");
        $('#new_password').prop("aria-invalid", "true");
    @endif
</script>
@stop
