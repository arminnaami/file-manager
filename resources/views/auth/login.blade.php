@extends('layouts.app')
@section('content')
<center>
<h3 class="">Please, login into your account</h3>
<div class="section"></div>
<div class="container">
    <div class="z-depth-1 grey lighten-5 row" id="login-holder">
        <form class="col s12" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col s12">
                </div>
            </div>
            <div class="row left-align">
                <div class="input-field col s12">

                    <input 
                        type="email" 
                        name="fmu_email" 
                        id="email" 
                        value="{{ old('fmu_email') }}" 
                        class="validate" 
                        autofocus>

                    <label for="email">Enter your email</label>
                </div>
            </div>
            <div class="row left-align">
                <div class="input-field col s12">
                    <input 
                        type="password" 
                        name="fmu_password" 
                        id="password" 
                        class="validate" 
                        >
                    <label for="password">Enter your password</label>
                </div>
                <label style="float: right;">
                    <a class="teal-text text-darken-1" href="{{ url('/password/reset') }}">
                        <b>Forgot Password?</b>
                    </a>
                </label>
                <div class="checkbox">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <br>
            <center>
            <div class="row">
                <button type="submit" name="btn_login" class="col s12 btn btn-large waves-effect">Login</button>
            </div>
            </center>
        </form>
    </div>
</div>
<a href="{{ url('/register') }}">Create account</a>
</center>
@endsection
@section('scripts')
<script type="text/javascript">
    @if ($errors->has('fmu_email'))
        Materialize.toast("{{ $errors->first('fmu_email') }}", 4000, 'red darken-4');
        $('#email').addClass("invalid");
        $('#email').prop("aria-invalid", "true");
    @endif
    @if ($errors->has('fmu_password'))
        Materialize.toast("{{ $errors->first('fmu_password') }}", 4000, 'red darken-4');
        $('#password').addClass("invalid");
        $('#password').prop("aria-invalid", "true");
    @endif
</script>
@endsection