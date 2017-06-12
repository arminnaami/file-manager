<form class="col s12" id='share_directory_form' role="form" method="POST" action="{{ url('/directory/share') }}">
    {{ csrf_field() }}
    <div id="share_directory" class="modal">
        <div class="modal-content">
            <h4>Share folder</h4>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12">
                        <input
                        type="email"
                        name="user_email"
                        id="user_email"
                        class="validate"
                        required
                        autofocus>
                        <label for="user_email">Enter user email</label>

                        <input
                        type="hidden"
                        id="dir_to_share"
                        name="directory_id">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <a id="get-dir-token" href='javascript:;'>Get Link</a>
                    </div>
                    <div class="input-field col s12" style="display:none;">
                        <input
                        type="text"
                        name="dir_token"
                        id="dir_token"
                        readonly=1>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
            <button type="button" name="share_directory" id="share_directory_modal_btn" class="modal-action waves-effect waves-green btn-flat">Share</button>
        </div>
    </div>
</form>
@section('scripts')
@parent
<script type="text/javascript">
    $('#share_directory_modal_btn').on('click', function(){
        $.post(
            '/directory/share',
            $('#share_directory_form').serialize())
        .done(function(response) {
            Materialize.toast('Direcotry has been shared!', 4000, 'green darken-4');
            $('#share_directory').modal('close');
        })
        .fail(function(xhr, status, error) {
            var errorMsg = JSON.parse(xhr.responseText);
            Materialize.toast(errorMsg.message, 4000, 'red darken-4');

            $('#user_email').addClass("invalid");
            $('#user_email').prop("aria-invalid", "true");
        });
    });
    $('#get-dir-token').on('click', function(){
        $.post(
            '/directory/get-dir-token',
            $('#share_directory_form').serialize())
        .done(function(response) {
            $("#dir_token").val(response.token).parents('div').first().show();
        })
    });
</script>
@stop
