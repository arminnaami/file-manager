<a class="btn-floating btn-large waves-effect waves-light mob-yes" id="mob-add-new" href="#mob-add-new-container"><i class="material-icons">add</i></a>

<div id="mob-add-new-container" class="modal bottom-sheet">
    <div style="border-bottom: 1px solid #e0e0e0; padding: 10px">
        New
    </div>
    <div class="container">
    <a href='#create_directory' class="activate_modal"><i class="material-icons" style='color:#26a69a; font-size: 50px'>create_new_folder</i></a>
    </div>

</div>

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){
            $('#mob-add-new').modal();
        });
    </script>
@stop
