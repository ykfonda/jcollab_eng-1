<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Pdfmodele']['id']) ): ?>
			Modifier un modèle
		<?php else: ?>
			Ajouter un modèle
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Pdfmodele',['id' => 'PdfmodeleEditForm','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<div class="alert alert-warning" style="padding: 5px;margin: 5px;text-align: center;">La taille des images recommandé doit étre (820x1150) est de type (.JPG).</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Image(820x1150)</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('image',['class' => 'form-control','label'=>false,'type'=>'file','accept'=>".jpg"]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'PdfmodeleEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
