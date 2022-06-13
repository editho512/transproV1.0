<!---- modal pour ajouter remorque --->
<div class="modal fade" id="modal-ajouter-remorque">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Ajouter un remorque</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-remorque">
                <form action="{{route('remorque.ajouter')}}" method="post" role="form" id="form-ajouter-remorque" >
                    @csrf
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Désignation :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nom" required>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-remorque" form="form-ajouter-remorque" class="float-right btn btn-primary">Ajouter</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter chauffeur-->

<!---- modal pour modification remorque --->
<div class="modal fade" id="modal-modification-remorque">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un remorque</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-remorque">
                <form action="" method="post" role="form" id="form-modification-remorque" >
                    @csrf
                    @method('patch')
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Désignation :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nom" required>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-modification-remorque" form="form-modification-remorque" class="float-right btn btn-primary">Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter chauffeur-->

<!---- modal pour suppression remorque --->
<div class="modal fade" id="modal-suppression-remorque">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un remorque</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-remorque">
                <form action="" method="post" role="form" id="form-suppression-remorque" >
                    @csrf
                    @method('patch')
                    <div class="row mt-1">
                        <div class="col-sm-4">
                            <label for="name">Désignation :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Nom" disabled>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href=""><button type="button" id="button-suppression-remorque"  class="float-right btn btn-danger">Supprimer</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter chauffeur-->