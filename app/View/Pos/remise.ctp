<div class="modal-header">
	<h4 class="modal-title">
		Remise Ticket
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Salepoint',['id' => 'SalepointRemiseTotal','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<?php echo $this->Form->input('id'); ?>
			<div class="col-md-6" style="min-height: 350px;" id="RemiseContainer">
				<div class="form-group row">
					<label class="control-label col-md-4 text-left">Remise(%)</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('remise',['class'=>'form-control','label'=>false,'required'=>true,'readonly'=>false,'min'=>0,'max'=>100,'id'=>'Remise','step'=>'any','type'=>'text','type'=>'text']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-4 text-left"></label>
					<div class="col-md-6">
		                <!-- KeyPad -->
		                <table style="width:100%;">
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="7" >7</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="8" >8</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="9" >9</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="4" >4</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="5" >5</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="6" >6</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="1" >1</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="2" >2</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="3" >3</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="±">±</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href="0">0</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemise" type="button" href=".">.</button></td>
		                    </tr>
		                    <tr>
		                        <td colspan="3"><button class="btn btn-primary btn-danger btn-block btn-sm easy_numpad_clear_remise" type="button" href="Clear"><i class="fa fa-eraser"></i> Vider</button></td>
		                    </tr>
		                    <tr>
		                        <td colspan="3"><button class="btn btn-primary btn-warning btn-block btn-sm easy_numpad_del_remise" type="button" href="Clear"><i class="fa fa-eraser"></i> Supprimer</button></td>
		                    </tr>
		                </table>
		                <!-- KeyPad -->
					</div>
				</div>
			</div>
			<div class="col-md-6" style="min-height: 350px;">
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Montant remisé</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('montant_remise',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'MontantRemise','step'=>'any','default'=>0]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Total</label>
					<div class="col-md-6">
						<?php echo $this->Form->hidden('total_apres_reduction',['id'=>'TotalTTCHidden','value'=>$total]); ?>
						<?php echo $this->Form->input('total_apres_reduction',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total','step'=>'any','default'=>0]); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'SalepointRemiseTotal','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
