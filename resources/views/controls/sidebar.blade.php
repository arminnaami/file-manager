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