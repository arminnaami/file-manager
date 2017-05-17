@extends('layouts.admin')
@section('content')
@if($package->id != '')
<form class="col s12" role="form" method="POST" action="{{ route('savePackage', ['id' => $package->id]) }}">
@else
<form class="col s12" role="form" method="POST" action="{{ route('storePackage') }}">
@endif
    {{ csrf_field() }}
		<div class="row">
			<div class="col s6 offset-s3">
				<ul class="collection with-header">
					<li class="collection-header">
						@if($package->id != '')
							<h4>Edit package</h4>
						@else
							<h4>Add package</h4>
						@endif
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s7">
								<strong>Package name</strong>
							</div>
							<div class="col s5 input-field mt0">
								 <input
			                    type="text"
			                    name="name"
			                    id="name"
			                    value="{{ $package->name }}"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s7">
								<strong>Package code</strong>
							</div>
							<div class="col s5 input-field mt0">
								 <input
			                    type="text"
			                    name="code"
			                    id="code"
			                    value="{{ $package->code }}"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s7">
								<strong>Max file size (MB)</strong>
							</div>
							<div class="col s5 input-field mt0">
								 <input
			                    type="text"
			                    name="max_file_size"
			                    id="max_file_size"
			                    value="{{ $package->max_file_size }}"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s7">
								<strong>Max inodes count</strong>
							</div>
							<div class="col s5 input-field mt0">
								 <input
			                    type="text"
			                    name="max_inodes"
			                    id="max_inodes"
			                    value="{{ $package->max_inodes }}"
			                    class="validate"
			                    required
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row valign-wrapper mb0">
							<div class="col s7">
								<strong>Max disk space (MB)</strong>
							</div>
							<div class="col s5 input-field mt0">
								 <input
			                    type="text"
			                    name="max_disk_space"
			                    id="max_disk_space"
			                    value="{{ $package->max_disk_space }}"
			                    class="validate"
			                    >
							</div>
						</div>
					</li>
					<li class="collection-item">
						<div class="row">
							<div class="col s6 left-align">
								<a href="{{ route('packages') }}" class="btn waves-effect grey">Back</a>
							</div>
							<div class="col s6 right-align">
								<button type="submit" name="btn_save" class="btn waves-effect">Save</button>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
</form>
@endsection
