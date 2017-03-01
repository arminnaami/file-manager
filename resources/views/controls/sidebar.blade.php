<ul id="slide-out" class="side-nav">
     <li>
        <div class="userView">
            <div class="background">
                <img src="{{URL::asset('/img/office.jpg')}}" />
            </div>
            <a href="{{ url('/profile') }}" id="user-profile-img"><img class="circle" src="{{URL::asset('/img/'.$user->profileImage->name.'.'.$user->profileImage->extension)}}"></a>
            <a href="{{ url('/profile') }}"><span class="white-text name">{{ $user->name }}</span></a>
            <a href="{{ url('/profile') }}"><span class="white-text email">{{ $user->email }}</span></a>
        </div>
    </li>
    <li @if(Route::current()->getName() == 'home') class="active" @endif ><a href="{{ url('/home') }}"><i class="material-icons">perm_media</i> My Drive</a></li>
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