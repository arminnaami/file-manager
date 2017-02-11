<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FileManager') }}</title>

    <!-- Styles -->
    <link href="/css/materialize.min.css" rel="stylesheet">
    <link href="/css/materialize-icon.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="application/octet-stream" type="text/css" href="{{ URL::asset('fonts/material-icons.woff2') }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="white center" role="navigation">
            <div class="nav-wrapper container">
                <a class="brand-logo" href="{{ url('/') }}" id="logo-container">
                        {{ config('app.name', 'FileManager') }}
                    </a>
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
                                        <strong>{{ $user->profileImage->name.'.'.$user->profileImage->extension }}</strong><br>
                                        <span>{{ $user->email }}</span><br><br>
                                        <a href="{{ url('/profile') }}" class="btn" id="profile_dropdown_myacc_btm">My profile</a>
                                        <a href="{{ url('/logout') }}"  onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"
                                             class="profile_dropdown_card_a">Logout</a>
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
        @if (!Auth::guest())
            <ul id="slide-out" class="side-nav" style="transform: translateX(0px);">
                <li>
                    <div class="userView">
                        <div class="background">
                            <img src="{{URL::asset('/img/office.jpg')}}" />
                        </div>
                        <a href="#!user" id="user-profile-img"><img class="circle" src="{{URL::asset('/img/'.$user->profileImage->name.'.'.$user->profileImage->extension)}}"></a>
                        <a href="#!name"><span class="white-text name">{{ $user->name }}</span></a>
                        <a href="#!email"><span class="white-text email">{{ $user->email }}</span></a>
                    </div>
                </li>
            </ul>
        @endif
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/materialize.min.js"></script>
    <script src="/js/app.js"></script>
    @yield('scripts')
    <script>
        @if (session('status'))
            Materialize.toast("{{ session('status') }}", 4000, 'green darken-4');
        @endif
        @if (session('alert-success'))
            Materialize.toast("{{ session('alert-success') }}", 4000, 'green darken-4');
        @endif
        @if(!Auth::guest())
            $('.dropdown-button').dropdown({
                inDuration: 300,
                outDuration: 225,
                constrain_width: false, // Does not change width of dropdown to that of the activator
                hover: true, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: true, // Displays dropdown below the button
                alignment: 'right' // Displays dropdown with edge aligned to the left of button
            });
            $( window ).resize(function() {
              if($( window ).width() < 991){
                $('#slide-out').hide();
                }else{
                    $('#slide-out').show();
                }
            });
        @endif
    </script>
</body>
</html>
