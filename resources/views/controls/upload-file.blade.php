<form class="col s12" id='upload_file_form' role="form" method="POST" action="{{ url('/file/create') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div id="upload_file" class="modal">
        <div class="modal-content">
            <h4>Upload file</h4>
            <div class="container">
                <div class="row">
                    <div class="file-field input-field col s9 mt0">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Disagree</a>
            <button type="submit" name="upload_file" class="modal-action waves-effect waves-green btn-flat">Agree</button>
        </div>
    </div>
</form>
