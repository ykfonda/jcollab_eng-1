<div class="modal-header">
	<h4 class="modal-title">
		Remise Produit
	</h4>
</div>
<div class="modal-body">
	<?php echo $this->Form->create('Salepointdetail',['id' => 'SalepointRemise','class' => 'form-horizontal']); ?>
		<div class="row">
			<?php echo $this->Form->input('id'); ?>
			<div class="col-md-6" id="RemiseLigneContainer">
				<div class="form-group row">
					<label class="control-label col-md-3">Remise (%)</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('remise',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'max'=>100,'id'=>'RemiseArticle','step'=>'any','default'=>0,'type'=>'text']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3"></label>
					<div class="col-md-6">
		                <!-- KeyPad -->
		                <table style="width:100%;">
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="7" >7</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="8" >8</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="9" >9</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="4" >4</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="5" >5</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="6" >6</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="1" >1</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="2" >2</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="3" >3</button></td>
		                    </tr>
		                    <tr>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="±">±</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href="0">0</button></td>
		                        <td><button class="btn btn-primary btn-block numberClickRemiseArticle" type="button" href=".">.</button></td>
		                    </tr>
		                    <tr>
		                        <td colspan="3"><button class="btn btn-primary btn-danger btn-block btn-sm easy_numpad_clear_remise_article" type="button" href="Clear"><i class="fa fa-eraser"></i> Vider</button></td>
		                    </tr>
		                    <tr>
		                        <td colspan="3"><button class="btn btn-primary btn-warning btn-block btn-sm easy_numpad_del_remise_article" type="button" href="Clear"><i class="fa fa-eraser"></i> Supprimer</button></td>
		                    </tr>
		                </table>
		                <!-- KeyPad -->
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Montant remise</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('montant_remise',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'MontantRemise','step'=>'any','default'=>0]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Prix</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('prix_vente',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>1,'id'=>'PrixVente','step'=>'any']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Qté cdée</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>1,'id'=>'Quantite','step'=>'any']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3 text-left">Total</label>
					<div class="col-md-6">
						<?php echo $this->Form->input('ttc',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total','step'=>'any']); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'SalepointRemise','class' => 'saveBtn btn btn-success btn-lg')) ?>
	<button type="button" class="btn default btn-lg" data-dismiss="modal">Annuler</button>
</div>