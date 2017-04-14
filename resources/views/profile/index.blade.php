@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col s12">
			<ul class="collection with-header">
				<li class="collection-header">
					<h4>Profile</h4>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s3">
							<strong>Name</strong>
						</div>
						<div class="col s9">
							{{$user->name}}
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s3">
							<strong>Email</strong>
						</div>
						<div class="col s9">
							{{$user->email}}
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s12 right-align">
							<a href="{{ url('/profile/edit') }}" class="btn waves-effect">Edit</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection
