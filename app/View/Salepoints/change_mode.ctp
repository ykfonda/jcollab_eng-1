<style>
[type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
[type=radio]:checked + img {
  outline: 2px solid #f00;
}


</style>
<div class="modal-header">
	
	<h4 class="modal-title">
		
			Changer le mode de paiement
		
	</h4>
</div>

<div class="modal-body">
<?php echo $this->Form->create('Avance',['id' => 'AvancePaiement','class' => 'form-horizontal','autocomplete'=>'off']); ?>


<div class="row">
		
		<div class="col-md-12">
			<div class="form-group row">
      <?php echo $this->Form->hidden('Avance.0.id',['default' => $this->data["Avance"][0]["id"]]); ?>

				<label class="control-label col-md-3">Montant 1</label>
				<div class="col-md-3">
        
        <?php echo $this->Form->input('Avance.0.montant',['class' => 'form-control','default' => $this->data["Avance"][0]["montant"] ,'label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Mode 1</label>
				<div class="col-md-4">
        <?php echo $this->Form->input('Avance.0.mode',['class' => 'select2 form-control','empty'=>'--Mode','default' => $this->data["Avance"][0]["mode"] ,'label'=>false,'required' => false]); ?>
				</div>
			</div>
      <div class="form-group row">
      <?php echo $this->Form->hidden('Avance.1.id',['default' => $this->data["Avance"][1]["id"]]); ?>

				<label class="control-label col-md-3">Montant 2</label>
				<div class="col-md-3">
        
        <?php echo $this->Form->input('Avance.1.montant',['class' => 'form-control','default' => $this->data["Avance"][1]["montant"] ,'label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Mode 2</label>
				<div class="col-md-4">
        <?php echo $this->Form->input('Avance.1.mode',['class' => 'select2 form-control','options' => $modes,'empty'=>'--Mode','default' => $this->data["Avance"][1]["mode"] ,'label'=>false,'required' => false]); ?>
				</div>
			</div>
      </div>
      </div>
      <?php echo $this->Form->end() ?>

<div class="modal-footer">
	
		<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'AvancePaiement','class' => 'saveBtn btn btn-success')) ?>
	
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>