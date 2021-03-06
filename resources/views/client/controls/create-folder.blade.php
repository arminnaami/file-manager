<form class="col s12" id='create_directory_form' role="form" method="POST" action="{{ url('/directory/create') }}">
    {{ csrf_field() }}
    <div id="create_directory" class="modal">
        <div class="modal-content">
            <h4>Create folder</h4>
            <div class="container">
                    <div class="row">
                        <div class="input-field col s12">
                            <input
                            type="text"
                            name="directory_name"
                            id="directory_name"
                            required
                            autofocus>
                            <label for="directory_name">Enter folder name</label>
                        </div>
                    </div>

            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
            <button type="submit" name="create_directory" class="modal-action waves-effect waves-green btn-flat">Create</button>
        </div>
    </div>
</form>
