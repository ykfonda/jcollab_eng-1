<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Information objectif
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ObjectifEditForm','class' => 'saveBtn btn btn-default')) ?>
		</div>
	</div>
	<div class="portlet-body">
	    <?php echo $this->Form->create('Objectif',['id' => 'ObjectifEditForm','class' => 'form-horizontal']); ?>
			<div class="row">
				<?php echo $this->Form->input('id'); ?>
				<div class="col-md-12">
					<div class="form-group row">
						<label class="control-label col-md-2">Vendeur</label>
						<div class="col-md-8">
							<?php echo $this->Form->input('user_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Vendeur']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-2">Date début</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('dated',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
						</div>
						<label class="control-label col-md-2">Date fin</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('datef',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-2">Total jrs travail</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('total_jrs_travail',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
						<label class="control-label col-md-2">C.A mensuel</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('c_a_mensuel',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-2">Visite mensuel</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('visite_mensuel',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
						<label class="control-label col-md-2">Nbr livraison</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('nbr_livraision',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-2">Taux (Liv/Visit)</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('taux',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
						<label class="control-label col-md-2">C.A moyen par liv</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('c_a_moyen',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
						</div>
					</div>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
  	</div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){

  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }
  
  Init();

  $('#ObjectifEditForm').on('submit',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data:formData,
      success : function(dt){
        toastr.success("L'enregistrement a été effectué avec succès.");
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
    });
  });

});
</script>
<?php $this->end() ?>