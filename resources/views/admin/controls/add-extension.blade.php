<form class="col s12" id='add_extension_form' role="form" method="POST" action="{{ route('addExtension') }}">
    {{ csrf_field() }}
    <div id="add_extension" class="modal">
        <div class="modal-content">
            <h4>Add extension</h4>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12">
                        <input
                        type="text"
                        name="extension"
                        id="extension_id"
                        required
                        autofocus>
                        <label for="extension_id">Enter extension</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
            <button type="submit" name="btn_add_extension" class="modal-action waves-effect waves-green btn-flat">Add</button>
        </div>
    </div>
</form>
