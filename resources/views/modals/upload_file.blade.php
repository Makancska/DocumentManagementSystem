<div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Új fájl feltöltése</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Név:</label>
                    <input type="text" class="form-control" id="docName" name="name">
                </div>
                <div class="form-group">
                    <label for="file">Fájl feltöltése:</label>
                    <input type="file" name="file" class="form-control-file" id="file">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
                    <button type="button" class="btn btn-primary" id="save-document">Mentés</button>
                </div>
            </div>
        </div>
    </div>
</div>