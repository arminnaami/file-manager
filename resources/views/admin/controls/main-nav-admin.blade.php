
<nav class="white center" id="top-nav" role="navigation">
    <div class="nav-wrapper container left-align">
         <a class="brand-logo" href="{{ url('/admin') }}" id="logo-container">
            {{ config('app.name', 'FileManager') }} - Control panel
        </a>
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="javascript:;" class='dropdown-button' id="profile_dropdown_btn" data-activates='profile_dropdown'>
                    @if($user->profile_picture == '')
                        <img src="{{URL::asset('/img/profile_picture.png')}}" class="circle">
                    @else
                        <img src="{{asset('storage/'.$user->id.'/'.$user->profile_picture)}}" class="circle">
                    @endif
                </a>
                <ul id='profile_dropdown' class='dropdown-content'>
                    <li>
                        <div id="profile_dropdown_card">
                            <div id="profile_dropdown_card_img_hldr">
                                @if($user->profile_picture == '')
                                    <img src="{{URL::asset('/img/profile_picture.png')}}" class="circle">
                                @else
                                    <img src="{{asset('storage/'.$user->id.'/'.$user->profile_picture)}}" class="circle">
                                @endif
                            </div>
                            <div id="profile_dropdown_card_account">
                                <strong>{{ $user->name}}</strong><br>
                                <span>{{ $user->email }}</span><br><br>
                                <a href="{{ url('/profile') }}" class="btn" id="profile_dropdown_myacc_btm">My profile</a>
                                <a href="{{ url('/logout') }}"  onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                                     class="profile_dropdown_card_a" id="logoutbtn">Logout</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
        @if (!Auth::guest())
        <a class="button-collapse" data-activates="slide-out" href="#" id="side-nav-btn">
            <i class="material-icons">
                menu
            </i>
        </a>
        @endif
    </div>
</nav>
@section('scripts')
@parent
    <script type="text/javascript">

        (function($) {
            $(function() {
                $('.dropdown-button').dropdown({
                    inDuration: 300,
                    outDuration: 225,
                    constrainWidth: false, // Does not change width of dropdown to that of the activator
                    hover: false, // Activate on hover
                    gutter: 0, // Spacing from edge
                    belowOrigin: true, // Displays dropdown below the button
                    alignment: 'left', // Displays dropdown with edge aligned to the left of button
                    stopPropagation: false // Stops event propagation
                });
                $('#profile_dropdown_btn.dropdown-button').dropdown({
                    inDuration: 300,
                    outDuration: 225,
                    constrain_width: false, // Does not change width of dropdown to that of the activator
                    hover: true, // Activate on hover
                    gutter: 0, // Spacing from edge
                    belowOrigin: true, // Displays dropdown below the button
                    alignment: 'right' // Displays dropdown with edge aligned to the left of button
                });
            }); // end of document ready
        })(jQuery); // end of jQuery name space
    </script>
@stop
