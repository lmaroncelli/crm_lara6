<form id="formAddRowSconto">
  @csrf
  <div class="form-group row">
    <div class="col-lg-8">
      <input class="form-control" id="nome" type="text" name="nome" value="SCONTO &nbsp; <?php echo $servizio->nome!= 'ALTRO' ? $servizio->nome : $servizio->altro_servizio ?>" readonly="readonly">
    </div>
    <div class="col-lg-2">
      <input class="form-control" id="importo" type="text" name="importo" value="" placeholder="importo">
    </div>
    <div class="col-lg-1">
      <button type="button" class="btn btn-primary btn-sm" id="addRowSconto">add</button>
    </div>
    <div class="col-lg-1">
      <button type="button" class="btn btn-danger btn-sm" id="closeRow">close</button>
    </div>
    <input type="hidden" name="idcontratto" value="<?php echo $idcontratto ?>">
    <input type="hidden" name="idservizio" value="<?php echo $servizio->id ?>">
  </div>
  <div id="response"></div>
</form>

