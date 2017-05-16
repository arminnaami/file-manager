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
        </div>
    </li>
    <li @if(Route::current()->getName() == 'admin') class="active" @endif ><a href="{{ route('admin') }}"><i class="material-icons">settings</i> Control Panel</a></li>
    <li @if(Route::current()->getName() == 'users') class="active" @endif ><a href="{{ route('users') }}"><i class="material-icons">people</i>Users</a></li>
    @if(Auth::user()->hasRole('ADMIN'))
        <li @if(Route::current()->getName() == 'managers') class="active" @endif ><a href="{{ route('managers') }}"><i class="material-icons">people_outline</i>Managers</a></li>
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
