<form class="col s12" id='rename_directory_form' role="form" method="POST" action="{{ url('/directory/rename') }}">
    {{ csrf_field() }}
    <div id="rename_dir" class="modal">
        <div class="modal-content">
            <h4>Rename directory</h4>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12">
                        <input
                        type="text"
                        name="dir_name"
                        id="dir_name"
                        class="validate"
                        required
                        autofocus>
                        <label for="dir_name">Enter directory name</label>

                        <input
                        type="hidden"
                        id="dir_to_rename"
                        name="dir_id">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="button" name="rename_dir" id="rename_dir_modal_btn" class="modal-action waves-effect waves-green btn-flat">Agree</button>
        </div>
    </div>
</form>
@section('scripts')
@parent
<script type="text/javascript">
    $('#rename_dir_modal_btn').on('click', function(){
        $.post(
            '/directory/rename',
            $('#rename_directory_form').serialize())
        .done(function(response) {
            Materialize.toast('Directory has been renamed!', 4000, 'green darken-4');
            setTimeout(function(){
                $('#rename_dir').modal('close');
                window.location = '';
            }, 1000);
        })
        .fail(function(xhr, status, error) {
            var errorMsg = JSON.parse(xhr.responseText);
            Materialize.toast(errorMsg.message, 4000, 'red darken-4');
            $('#dir_name').addClass("invalid");
            $('#dir_name').prop("aria-invalid", "true");
        });
    });
</script>
@stop
