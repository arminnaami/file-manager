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
                    <input class="validate" name="fmu_email" id="email" type="email" value="{{ old('fmu_email') }}" required autofocus>
                    <label for="email">Enter your email</label>
                </div>
            </div>
            <div class="row left-align">
                <div class="input-field col s12">
                    <input class="validate" name="fmu_password" id="password" type="password" required>
                    <label for="password">Enter your password</label>
                </div>
                <label style="float: right;">
                    <a class="teal-text text-darken-1" href="{{ url('/password/reset') }}">
                        <b>Forgot Password?</b>
                    </a>
                </label>
                <div class="checkbox">
                    <input type="checkbox" name="remember" id="remember">
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
<a ng-href="/#/register" href="/#/register">Create account</a>
</center>
{{--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                Login
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
@endsection