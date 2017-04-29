<form class="col s12" id='share_file_form' role="form" method="POST" action="{{ url('/file/share') }}">
    {{ csrf_field() }}
    <div id="share_file" class="modal">
        <div class="modal-content">
            <h4>Share file</h4>
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
                        id="file_to_share"
                        name="file_id">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <a id="get-file-token" href='javascript:;'>Get Link</a>
                    </div>
                    <div class="input-field col s12" style="display:none;">
                        <input
                        type="text"
                        name="file_token"
                        id="file_token"
                        readonly=1>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="button" name="share_file" id="share_file_modal_btn" class="modal-action waves-effect waves-green btn-flat">Agree</button>
        </div>
    </div>
</form>
@section('scripts')
@parent
<script type="text/javascript">
    $('#share_file_modal_btn').on('click', function(){
        $.post(
            '/file/share',
            $('#share_file_form').serialize())
        .done(function(response) {
            Materialize.toast('File has been shared!', 4000, 'green darken-4');
            $('#share_file').modal('close');
        })
        .fail(function(xhr, status, error) {
            var errorMsg = JSON.parse(xhr.responseText);
            Materialize.toast(errorMsg.message, 4000, 'red darken-4');
            $('#user_email').addClass("invalid");
            $('#user_email').prop("aria-invalid", "true");
        });
    });
    $('#get-file-token').on('click', function(){
        $.post(
            '/file/get-file-token',
            $('#share_file_form').serialize())
        .done(function(response) {
            $("#file_token").val(response.token).parents('div').first().show();
        })
    });
</script>
@stop
