<form class="col s12" id='rename_file_form' role="form" method="POST" action="{{ url('/file/rename') }}">
    {{ csrf_field() }}
    <div id="rename_file" class="modal">
        <div class="modal-content">
            <h4>Rename file</h4>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12">
                        <input
                        type="text"
                        name="file_name"
                        id="file_name"
                        class="validate"
                        required
                        autofocus>
                        <label for="file_name">Enter file name</label>

                        <input
                        type="hidden"
                        id="file_to_rename"
                        name="file_id">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="button" name="rename_file" id="rename_file_modal_btn" class="modal-action waves-effect waves-green btn-flat">Agree</button>
        </div>
    </div>
</form>
@section('scripts')
@parent
<script type="text/javascript">
    $('#rename_file_modal_btn').on('click', function(){
        $.post(
            '/file/rename',
            $('#rename_file_form').serialize())
        .done(function(response) {
            Materialize.toast('File has been renamed!', 4000, 'green darken-4');
            setTimeout(function(){
                $('#rename_file').modal('close');
                window.location = '';
            }, 1000);
        })
        .fail(function(xhr, status, error) {
            var errorMsg = JSON.parse(xhr.responseText);
            Materialize.toast(errorMsg.message, 4000, 'red darken-4');
            $('#file_name').addClass("invalid");
            $('#file_name').prop("aria-invalid", "true");
        });
    });
</script>
@stop
