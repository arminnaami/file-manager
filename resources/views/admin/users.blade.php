@extends('layouts.admin')
@section('content')
<div class="container">
	<br />
	<br />
	<h4 class="center">Users</h4>
	<br />
	<br />

	{{ $users->links('admin.controls.pagination') }}
	<ul class="collection">
		@foreach ($users as $user)
			<li class="collection-item avatar user-row">
				@if($user->profile_picture == '')
					<img src="{{URL::asset('/img/profile_picture.png')}}" class="circle">
				@else
					<img src="{{asset('storage/'.$user->id.'/'.$user->profile_picture)}}" class="circle">
				@endif
				<span class="title">
					{{ $user->name }}
					@if($user->is_blocked)
						<i class="material-icons" style="font-size: 12px;" title="Blocked">lock</i>
					@endif
				</span>
				<p>
					{{ $user->email }}
				</p>
				@if(Auth::user()->id != $user->id)
					<div class="fixed-action-btn horizontal right click-to-toggle" style="bottom: 20px;">
						<a class="btn-floating btn-large">
							<i class="material-icons">menu</i>
						</a>
						<ul>
							<li>
								@if($user->is_blocked)
									<a class="btn-floating green lighten-1" href="{{ route('unblockUser', ['id' => $user->id]) }}" title="Unblock">
										<i class="material-icons">lock_open</i>
									</a>
								@else
									<a class="btn-floating red lighten-1" href="{{ route('blockUser', ['id' => $user->id]) }}" title="Block">
										<i class="material-icons">lock</i>
									</a>
								@endif
								
							</li>
							@if(Auth::user()->hasRole('admin'))
								@if($user->hasRole('manager'))
									<li>
										<a class="btn-floating red darken-4" href="{{ route('removeManager', ['id' => $user->id]) }}" title="Remove manager">
											<i class="material-icons">star</i>
										</a>
									</li>
								@else
									<li>
										<a class="btn-floating light-blue darken-1" href="{{ route('makeManager', ['id' => $user->id]) }}" title="Make manager">
											<i class="material-icons">star</i>
										</a>
									</li>
								@endif
							@endif
						</ul>
					</div>
				@endif
			</li>
		@endforeach
	</ul>
	{{ $users->links('admin.controls.pagination') }}
</div>
@endsection

@section('scripts')
	@parent
	<script type="text/javascript">
	$('.user-row').on('click', function(){
		$('.user-row').not(this).removeClass('active');
		$('.directory-row').not(this).removeClass('active');
		$(this).addClass('active');
	});
	</script>
@endsection

