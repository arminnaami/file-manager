@extends('app')
<!-- Main Content -->
@section('content')
<center>
<h3 class="">Please, enter your email address</h3>
<div class="section"></div>
<div class="container">
    <div class="z-depth-1 grey lighten-5 row main-form" id="email-holder">
        <form class="col s12" role="form" method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col s12">
                </div>
            </div>
            <div class="row left-align">
                <div class="input-field col s12">
                    <input
                    id="email"
                    type="email"
                    class="validate"
                    name="email"
                    value="{{ old('email') }}"
                    required>
                    <label  for="email">E-Mail Address</label>
                </div>
            </div>
            <br>
            <center>
            <div class="row">
                <button type="submit" name="btn_login" class="col s12 btn btn-large waves-effect">Send Password Reset Link</button>
            </div>
            </center>
        </form>
    </div>
</div>
</center>
@endsection
@section('scripts')
<script type="text/javascript">
    @if($errors->has('email'))
        Materialize.toast("{{ $errors->first('email') }}", 4000, 'red darken-4');
        $('#email').addClass("invalid");
        $('#email').prop("aria-invalid", "true");
    @endif
</script>
@endsection
