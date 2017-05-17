@extends('layouts.admin')
@section('content')
<br />
<br />
<h4 class="center">Packages</h4>
<br />
<br />
<div class="center">
	<a class="waves-effect waves-light btn" href="{{ route('addPackage') }}">Add package</a>
</div>
<br />
<br />
<div class="row">
    @foreach($packages as $package)
		<div class="col s12 m4">
			<div class="card blue-grey darken-1">
				<div class="card-content white-text">
					<span class="card-title">{{$package->name}}</span>
					<ul>
						<li>
							Code: <strong>{{ $package->code }}</strong>
						</li>
						<li>
							Max file size: <strong>{{ $package->max_file_size }} MB</strong>
						</li>
						<li>
							Max inodes: <strong>{{ $package->max_inodes }}</strong>
						</li>
						<li>
							Max disk space: <strong>{{ $package->max_disk_space }} MB</strong>
						</li>
					</ul>
				</div>
				<div class="card-action">
					<a href="{{ route('editPackage', ['id' => $package->id]) }}">Edit</a>
				</div>
			</div>
		</div>
    @endforeach
@endsection
