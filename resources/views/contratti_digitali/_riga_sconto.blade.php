<form id="formAddRowSconto">
  <div class="row">
    <div class="col-md-8 col-xs-12"><input type="text" name="nome" id="nome" value="SCONTO &nbsp; <?php echo $servizio->nome!= 'ALTRO' ? $servizio->nome : $servizio->altro_servizio ?>" class="form-control" readonly="readonly"></div>
    <div class="col-md-2 col-xs-12" style="text-align: right;"><input type="text" name="importo" id="importo" value="" size="20" class="form-control"></div>
    <div class="col-md-2 col-xs-12"><button type="button" class="btn btn-primary btn-sm" id="addRowSconto">add</button></div>
  </div>
  <input type="hidden" name="idfoglioservizi" value="<?php echo $idfoglioservizi ?>">
  <input type="hidden" name="idservizio" value="<?php echo $servizio->id ?>">
</form>