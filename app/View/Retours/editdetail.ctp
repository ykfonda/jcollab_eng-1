<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Retourdetail']['id']) ): ?>
			Modifier un article
		<?php else: ?>
			Ajouter un article
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Retourdetail',['id' => 'RetourdetailEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->hidden('id'); ?>
		<?php echo $this->Form->hidden('prixachat',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'PrixAchat']); ?>
		<?php echo $this->Form->hidden('total',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total']); ?>
		<?php echo $this->Form->hidden('tva',['type'=>'hidden','id'=>'TVA']); ?>
		<?php echo $this->Form->hidden('ttc',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'TotalTVA']); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Catégorie</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Retourdetail']['id']) ): ?>
					<?php echo $this->Form->input('categorieproduit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
					<?php echo $this->Form->input('categorieproduit_id',['label'=>false,'type'=>'hidden','id'=>'CategorieID']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('categorieproduit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'CategorieID']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Article</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Retourdetail']['id']) ): ?>
					<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
					<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden','id'=>'ArticleID']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'ArticleID']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'id'=>'QteChange']); ?>
				</div>
				<label class="control-label col-md-2">Déclaration</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('declaration',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'-- Déclaration','options'=>$this->App->getDeclaration() ]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'RetourdetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>