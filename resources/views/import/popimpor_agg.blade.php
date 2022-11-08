<div class="modal inmodal fade" id="impor_agg_all" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_impor_agg_all" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">IMPORTAR EXCEL AGG</h6>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{url('importAgg')}}">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" type="file" name="file" /> 
                    </div>
                    <center>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-o"></i> Subir
                        </button>
                        <span class="text-muted">.xls, .xslx</span>  
                    </center>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>