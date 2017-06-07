@extends('admin.admin')
@section('content')
<div class="container">
	<br />
	<h4 class="center">Extensions</h4>
	<br />
	<div class="center">
		<a class="waves-effect waves-light btn" href="#add_extension">Add extension</a>
	</div>
	<br />
	<div class="row">
		<div class="col s6">
			<h4 class="center">Enabled extensions</h4>
		</div>
		<div class="col s6">
			<h4 class="center">Blocked extensions</h4>
		</div>
	</div>
	<div class="row">
		<div class="col s6">
			<form method="POST" action="{{ route('extensions') }}" role="form">
				{{ csrf_field() }}
				<div class="row valign-wrapper" style="padding-right: 35px;">
					<div class="col s10">
						<div class="input-field">
							<input name="search_enabled" id="search_enabled" type="search" value="{{ $searchEnabled }}">
							<label class="label-icon" for="search_enabled"><i class="material-icons">search</i></label>
							<i class="material-icons">close</i>
						</div>
					</div>
					<div class="col s2">
						<input type="hidden" name="is_blocked" value="0">
						<input type="hidden" name="do_search" value="1">
						<button type="submit" name="btn_search" class="btn waves-effect"><i class="material-icons">search</i></button>
					</div>
				</div>
			</form>
			@if( count($extensions) > 0 )
				<ul class="collection">
					@foreach ($extensions as $extension)
						<li class="collection-item relative">
							<svg class="icon file-icon">
								<use xlink:href="{{ URL::asset('/img/file_extensions.svg') }}
									{{$extension->icon_id}}
								"></use>
							</svg>
							<span class="title">
								.{{ $extension->id }}
							</span>
							<div class="fixed-action-btn horizontal right click-to-toggle">
								<a class="btn-floating btn-large">
									<i class="material-icons">menu</i>
								</a>
								<ul>
									<li>
										<a class="btn-floating red lighten-1" href="{{ route('blockExtension', ['id' => $extension->id]) }}" title="Unblock">
											<i class="material-icons">lock</i>
										</a>

									</li>
								</ul>
							</div>
						</li>
					@endforeach
				</ul>
			@else
				<p class="center">No records found</p>
			@endif
		</div>
		<div class="col s6">
			<form method="POST" action="{{ route('extensions') }}" role="form">
			{{ csrf_field() }}
				<div class="row valign-wrapper" style="padding-right: 35px;">
					<div class="col s10">
						<div class="input-field">
							<input name="search_blocked" id="search_blocked" type="search" value="{{ $searchBlocked }}">
							<label class="label-icon" for="search_blocked"><i class="material-icons">search</i></label>
							<i class="material-icons">close</i>
						</div>
					</div>
					<div class="col s2">
						<input type="hidden" name="is_blocked" value="1">
						<input type="hidden" name="do_search" value="1">
						<button type="submit" name="btn_search" class="btn waves-effect"><i class="material-icons">search</i></button>
					</div>
				</div>
			</form>
			@if( count($blocked) > 0 )
				<ul class="collection">
					@foreach ($blocked as $blockedExt)
						<li class="collection-item relative">
							<svg class="icon file-icon">
								<use xlink:href="{{ URL::asset('/img/file_extensions.svg') }}
									{{$blockedExt->icon_id}}
								"></use>
							</svg>
							<span class="title">
								.{{ $blockedExt->id }}<i class="material-icons" style="font-size: 12px;">lock</i>
							</span>
							<div class="fixed-action-btn horizontal right click-to-toggle">
								<a class="btn-floating btn-large">
									<i class="material-icons">menu</i>
								</a>
								<ul>
									<li>
										<a class="btn-floating green lighten-1" href="{{ route('unblockExtension', ['id' => $blockedExt->id]) }}" title="Unblock">
											<i class="material-icons">lock_open</i>
										</a>

									</li>
								</ul>
							</div>
						</li>
					@endforeach
				</ul>
			@else
				<p class="center">No records found</p>
			@endif
		</div>
	</div>
</div>
@include('admin.controls.add-extension')
@endsection

@section('scripts')
	@parent
	<script type="text/javascript">
	$('.collection-item').on('click', function(){
		$('.collection-item').not(this).removeClass('active');
		$(this).addClass('active');
	});
	</script>
@endsection
