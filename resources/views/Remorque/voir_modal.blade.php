{{-- Debut papier --}}
<!---- modal pour ajouter papier --->
<div class="modal fade" id="modal-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Ajouter un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="{{route('remorque.papier.ajouter')}}" method="post" role="form" id="form-ajouter-papier" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="remorque_id" value={{$remorque->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label for="photo">Photo</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                </div>
                                <div class="custom-file">
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-papier" form="form-ajouter-papier" class="float-right btn btn-success"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter papier-->


<!---- modal pour modifier papier --->
<div class="modal fade" id="modal-modifier-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="" method="post" role="form" id="form-modifier-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label for="photo">Photo</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                </div>
                                <div class="custom-file">
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-modifier-papier" form="form-modifier-papier" class="float-right btn btn-primary"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

<!---- modal pour supprimer papier --->
<div class="modal fade" id="modal-supprimer-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-supprimer-papier">
                <form action="#" method="post" role="form" id="form-supprimer-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <input type="hidden" name="camion_id" value={{"" /* $camion->id*/}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input disabled type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" id="button-supprimer-papier" form="form-supprimer-papier" class="float-right btn btn-danger"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>

                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

{{-- Fin papier --}}