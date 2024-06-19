<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jogosultságok kezelése</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mx-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="permissionDownload">
                        <label class="form-check-label" for="gridCheck">
                            Letöltés engedélyezése
                        </label>
                    </div>
                </div>
                <div class="row mx-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="permissionUpload">
                        <label class="form-check-label" for="gridCheck">
                            Feltöltés engedélyezése
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégsem</button>
                <button type="button" class="btn btn-primary" id="permission">Mentés</button>
            </div>
        </div>
    </div>
</div>
