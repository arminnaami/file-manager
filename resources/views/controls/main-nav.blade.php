
<nav class="white center" @if (!Auth::guest()) id="logged-nav" @endif role="navigation">
    <div class="nav-wrapper container left-align">
        <a class="brand-logo" href="{{ url('/') }}" id="logo-container">
                {{ config('app.name', 'FileManager') }}
        </a>
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        @if (!Auth::guest())
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class='dropdown-button btn btn-thinner' href='#' data-activates='upload_drpdn'>New</a>
            <ul id='upload_drpdn' class='dropdown-content'>
                <li><a href="#create_directory"><i class="material-icons">create_new_folder</i>&nbsp;Create new folder</a></li>
                <li class="divider"></li>
                <li><a href="#!"><i class="material-icons">file_upload</i>&nbsp;File upload</a></li>
                <li><a href="#!"><i class="material-icons">folder</i>&nbsp;Folder upload</a></li>
            </ul>
          @endif
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}



        <ul class="right hide-on-med-and-down">
        @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
        @else
            <li>
                <a href="javascript:;" class='dropdown-button' id="profile_dropdown_btn" data-activates='profile_dropdown'>
                    <img src="{{URL::asset('/img/'.$user->profileImage->name.'.'.$user->profileImage->extension)}}" class="circle">
                </a>
                <ul id='profile_dropdown' class='dropdown-content'>
                    <li>
                        <div id="profile_dropdown_card">
                            <div id="profile_dropdown_card_img_hldr">
                                <img src="{{URL::asset('/img/'.$user->profileImage->name.'.'.$user->profileImage->extension)}}" class="circle">
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
        @endif
        </ul>
        <ul class="side-nav" id="nav-mobile">
             @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
            @else
                <li>
                    <a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            @endif
        </ul>
        <a class="button-collapse" data-activates="nav-mobile" href="#">
            <i class="material-icons">
                menu
            </i>
        </a>
    </div>
</nav>
