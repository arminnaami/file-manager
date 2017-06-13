<form class="col s12" id='upload_file_form' role="form" method="POST" action="{{ url('/file/create/') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    @if(isset($directory))
    <input type="hidden" name="dir_id" value="{{$directory->id}}">
    @endif
    <div id="upload_file" class="modal">
        <div class="modal-content">
            <h4>Upload file</h4>
            <div class="container">
                <div class="row">
                    <div class="file-field input-field col s9 mt0">
                        <div class="btn">
                            <span>File</span>
                            <input id="file_input" type="file" name="file" required >
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
            <button name="upload_file" id="upload_file_btn" class="modal-action waves-effect waves-green btn-flat">Upload</button>
        </div>
    </div>
</form>

@section('scripts')
    @parent
    <script type="text/javascript">
        $('#upload_file_btn').on('click', function(e){
            if($('#file_input').val() == '' ){
                return;
            }else{
                $('<div id="loading"><div>Loading...</div></div>').appendTo('body');
              $(this).parents('form').first().submit();
            }

        });
    </script>
@endsection
