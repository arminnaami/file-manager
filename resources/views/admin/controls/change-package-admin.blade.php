<form class="col s12" id='change_package_form' role="form" method="POST" action="{{ url('/admin/users/change-package') }}">
    {{ csrf_field() }}
    <div id="change_package" class="modal" style="overflow: visible;">
        <div class="modal-content">
            <h4>Change package</h4>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s12">
                        <select name="user_package_id" id="user_package_id" required="required">
                          <option value="" disabled selected>Choose package</option>
                          @foreach($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }} | Disk space {{ $package->max_disk_space }} MB | File size {{ $package->max_file_size }} MB</option>
                          @endforeach
                        </select>
                        <label>Select package</label>
                      </div>

                        <input
                        type="hidden"
                        id="user_id"
                        name="user_id">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a>
            <button type="button" name="change_package" id="change_package_btn" class="modal-action waves-effect waves-green btn-flat">Change</button>
        </div>
    </div>
</form>
@section('scripts')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        $('#change_package_btn').on('click', function(){
            $('<div id="loading"><div>Loading...</div></div>').appendTo('body');
            $.post(
                '/admin/users/change-package',
                $('#change_package_form').serialize())
            .done(function(response) {
                $('#loading').remove();
                Materialize.toast('User package has been changed!', 4000, 'green darken-4');
                setTimeout(function(){
                    location = ''
               },2000)
                return;
            })
            .fail(function(xhr, status, error) {
                $('#loading').remove();
                var errorMsg = JSON.parse(xhr.responseText);
                Materialize.toast(errorMsg.message, 4000, 'red darken-4');
                return;
            });
        });
        $('select').material_select();
      });
</script>
@stop
