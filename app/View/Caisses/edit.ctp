<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Caisse']['id']) ): ?>
			Modifier une caisse
		<?php else: ?>
			Nouvelle saisie
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Caisse',['id' => 'CaisseEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Adresse IP</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ip_adresse',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Store</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('store_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Store','id'=>'StoreId']); ?>
				</div>
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('societe_id',['class' => 'societe_id form-control','label'=>false,'disabled' => true,'empty'=>'--Société']); ?>
					<?php echo $this->Form->hidden('societe_id',['class' => 'societe_id']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prefix Compteur</label>
				<div class="col-md-3">
				<?php if(isset($this->data['Caisse']['id'])) : ?>	
					<?php echo $this->Form->input('prefix',['class' => 'form-control','label'=>false,'disabled' => true,'required' => true]); ?>
				<?php else : ?>
					<?php echo $this->Form->input('prefix',['class' => 'form-control','label'=>false,'required' => true]); ?>
				<?php endif ?>
				</div>
				<label class="control-label col-md-2">Numero</label>
				<div class="col-md-3">
				<?php if(isset($this->data['Caisse']['id'])) : ?>	
					<?php echo $this->Form->input('numero',['class' => 'form-control','label'=>false,'type' => "number",'disabled' => true,'required' => true]); ?>
				<?php else : ?>
					<?php echo $this->Form->input('numero',['class' => 'form-control','label'=>false,'type' => "number",'required' => true]); ?>
				<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Compteur actif</label>
				<div class="col-md-3">
				<?php if(isset($this->data['Caisse']['id'])) : ?>	
					<select name="data[Caisse][compteur_actif]" disabled class="form-control"  required="required">
					<option value="1" <?php if(isset($this->data['Caisse']['compteur_actif']) and $this->data['Caisse']['compteur_actif'] == "1")  echo ' selected';  ?>>Oui</option>
                    <option value="0" <?php if(isset($this->data['Caisse']['compteur_actif']) and $this->data['Caisse']['compteur_actif'] == "0")  echo ' selected';  ?>>Non</option>
           
                </select>	<?php else : ?>
					<select name="data[Caisse][compteur_actif]" disabled class="form-control"  required="required">
					<option value="1" >Oui</option>
                 
                </select><?php endif ?>	
				
				</div>
			</div>
			<hr>
			<div class="form-group row">
				<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
				<?php echo $this->Form->input('montant',['class' => 'form-control','label'=>false,'type' => "float",'disabled' => true]); ?>
				</div>
				<label class="control-label col-md-2">Pourcentage</label>
				<div class="col-md-3">
				<?php echo $this->Form->input('pourcentage',['class' => 'form-control','label'=>false,'type' => "float",'required' => true]); ?>
			    </div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'CaisseEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
