<div class="modal-header">
	<h4 class="modal-title">
		Effectuez un paiement
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Salepoint',['id' => 'SalepointPaiement','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<?php echo $this->Form->input('id'); ?>
		<?php $net_a_payer = $this->data['Salepoint']['total_apres_reduction'] ?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row mb-1 pb-1 pt-1" style="border:1px solid #e5e5e5;">
					<label class="control-label col-md-1"></label>
					<div class="col-md-3 mr-2">
						<?php echo $this->Form->input('total_apres_reduction',['class'=>'form-control','label'=>'Net à payer','readonly'=>true,'min'=>0,'id'=>'MontantTotal','step'=>'any','default'=>0]); ?>
					</div>
					<div class="col-md-3 mr-2">
						<?php echo $this->Form->input('remise',['class'=>'form-control','label'=>'Remise (%)','readonly'=>true,'min'=>0,'id'=>'Remise','step'=>'any','default'=>0]); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input('montant_remise',['class'=>'form-control','label'=>'Total Remise (Dhs)','readonly'=>true,'min'=>0,'max'=>100,'id'=>'MontantRemise','step'=>'any','default'=>0]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 pb-2 pt-2" style="border:1px solid #e5e5e5;">
				<h3 style="text-transform: uppercase;text-decoration: underline;font-weight: bold;">Mode 1</h3>
				<div class="form-group row mb-1 pb-1 pt-1">
					<div class="col-md-6">
						<?php echo $this->Form->hidden('Avance.0.date',['default' => date('d-m-Y')]); ?>
						<?php echo $this->Form->input('Avance.0.mode',['class'=>'form-control','label'=>'Mode paiement','required'=>true,'options'=>$this->App->getModePaiment(),'default' => 1 ]); ?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Form->input('Avance.0.montant',['onclick'=>"show_easy_numpad(this);",'class'=>'form-control','label'=>'Montant payé','required'=>true,'default'=>$net_a_payer ,'min'=>0,'step'=>'any','id'=>'Montant1','type'=>'number','max'=>$net_a_payer ]); ?>
					</div>
				</div>
			</div>
			<div class="col-md-6 pb-2 pt-2" style="border:1px solid #e5e5e5;">
				<h3 style="text-transform: uppercase;text-decoration: underline;font-weight: bold;">Mode 2</h3>
				<div class="form-group row mb-1 pb-1 pt-1">
					<div class="col-md-6">
						<?php echo $this->Form->hidden('Avance.1.date',['default' => date('d-m-Y')]); ?>
						<?php echo $this->Form->input('Avance.1.mode',['class'=>'form-control','label'=>'Mode paiement','required'=>true,'options'=>$this->App->getModePaiment(),'default' => 2 ]); ?>
					</div>
					<div class="col-md-6">
						<?php echo $this->Form->input('Avance.1.montant',['onclick'=>"show_easy_numpad(this);",'class'=>'form-control','label'=>'Montant payé','required'=>true,'default'=>0,'min'=>0,'step'=>'any','id'=>'Montant2','type'=>'number','max'=>$net_a_payer ]); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Valider & Terminer',array('div' => false,'form' => 'SalepointPaiement','class' => 'saveBtn btn btn-success','disabled'=>false)) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>