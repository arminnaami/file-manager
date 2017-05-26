<ul id="slide-out" class="side-nav">
     <li>
        <div class="userView">
            <div class="background">
                <img src="{{URL::asset('/img/office.jpg')}}" />
            </div>
            <a href="{{ url('/profile') }}" id="user-profile-img">
                @if($user->profile_picture == '')
                    <img src="{{URL::asset('/img/profile_picture.png')}}" class="circle">
                @else
                    <img src="{{asset('storage/'.$user->id.'/'.$user->profile_picture)}}" class="circle">
                @endif
            </a>
            <a href="{{ url('/profile') }}"><span class="white-text name">{{ $user->name }}</span></a>
            <a href="{{ url('/profile') }}"><span class="white-text email">{{ $user->email }}</span></a>
            <div class="row">
                <div class="col">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title"><strong>{{$user->package->name}}</strong></span>
                            <br />
                            <p>
                                Disk space: <strong style="white-space: nowrap;">{{$freeSpace}} MB from {{ $user->package->max_disk_space }} MB</strong>
                                <br>
                                Max file size: <strong>{{$user->package->max_file_size}} MB</strong>
                                <br>
                                <span title="Maximum files and directories count">Max Inodes: <strong>{{$user->package->max_inodes}}</strong></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li @if(Route::current()->getName() == 'home') class="active" @endif ><a href="{{ url('/home') }}"><i class="material-icons">perm_media</i> My Drive</a></li>
    <li @if(Route::current()->getName() == 'sharedWithMe') class="active" @endif ><a href="{{ url('/shared-with-me') }}"><i class="material-icons">folder_shared</i> Shared with me</a></li>

    @if($user->hasRole('MANAGER'))
        <li><div class="divider"></div></li>
        <li @if(Route::current()->getName() == 'admin') class="active" @endif ><a href="{{ url('/admin') }}"><i class="material-icons">settings</i> Control Panel</a></li>
    @endif
</ul>

@section('scripts')
@parent
<script type="text/javascript">
(function($) {
    $(function() {
         $("#side-nav-btn").sideNav();
         function toggleSideNav(){
            if ($(window).width() < 991) {
                $('#slide-out').css('transform', 'translateX(-100%)');
            } else {
                $('#slide-out').css('transform', 'translateX(100%)');
            }
         }
         toggleSideNav();
         $(window).resize(function() {
           toggleSideNav();
        });
    }); // end of document ready
})(jQuery); // end of jQuery name space
</script>
@stop
