<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Entrée en masse
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ($globalPermission['Permission']['i']): ?>
		        <a target="_blank" href="<?php echo $this->Html->url(['action' => 'journal']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-ticket"></i> Imprimer journal </a>
	      	<?php endif ?>
			<?php echo $this->Form->button('Valider l\'entrée',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'MouvementEditForm','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
    	<?php echo $this->Form->create('Mouvement',['id' => 'MouvementEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">


				<div class="form-group row row">
					<label class="control-label col-md-2">Date entrée</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'default'=>date('d-m-Y'),'type'=>'text' ]); ?>
					</div>
					<label class="control-label col-md-2">Date sortie</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false,'required' => false,'type'=>'text' ]); ?>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="control-label col-md-2">Fournisseur</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('fournisseur_id',['class' => 'select2 form-control','label'=>false,'required' => false,'empty'=>'-- Fournisseur']); ?>
					</div>
				</div>

				<div class="form-group row row">
					<label class="control-label col-md-2">Dépot</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotID']); ?>
					</div>
					<label class="control-label col-md-2">Numéro de lot</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('num_lot',['class' => 'form-control','label'=>false,'required' => true]); ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-2">Description</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('description',['class' => 'form-control','label'=>false,'required' => false]); ?>
					</div>
				</div>

				<div class="form-group row row">
					<div class="col-md-12">
						<table id="dynamique_data" class="table table-striped table-bordered text-center">
	                        <thead>
	                            <tr>
	                                <th style="width: 40%;">Produit</th>
	                                <th style="width: 20%;">Quantité</th>
	                                <th style="width: 20%;" class="actions">
	                                	<?php if ($globalPermission['Permission']['a']): ?>
										 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
										 		<i class="fa fa-plus"></i> Ajouter un produit
										 	</button>
							      		<?php endif ?>
	                                </th>                                    
	                            </tr>
	                        </thead>
	                        <tbody id="Main">
	                        	
	                        </tbody>
	                        <thead>
	                            <tr style="border-top: 1px solid silver;">
	                                <th style="width: 40%;"></th>
	                                <th style="width: 20%;"></th>
	                                <th style="width: 20%;" class="actions">
	                                	<?php if ($globalPermission['Permission']['a']): ?>
										 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
										 		<i class="fa fa-plus"></i> Ajouter un produit
										 	</button>
							      		<?php endif ?>
	                                </th>                                    
	                            </tr>
	                        </thead>
	                    </table>
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

  	$('.addRow').on('click',function(e){
	    e.preventDefault();
        var count = $('tbody#Main .child').length;
        var depot_id = $('#DepotID').val();
        $('.addRow').attr('disabled',true);
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    $.ajax({
	      url: $(this).attr('href')+'/'+count+'/'+depot_id,
	      success: function(dt){
			$('tbody#Main').append(dt);
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	      	$('.addRow').attr('disabled',false);
	        Init();
	      }
	    });
  	});

  	$('#Main').on('click','.deleteRow',function(e){
        e.preventDefault();
        var element = $(this);
        element.closest('.child').remove();
        var count = $('tbody#Main .child').length;
        if( count == 0 ) $('.saveBtn').attr('disabled',true);
	    else $('.saveBtn').attr('disabled',false);
    });

    $('#Main').on('input','.stock_source',function(e){
    	var element = $(this).closest('.child');
    	calcul(element);
  	});

  	$('#Main').on('input','.paquet_source',function(e){
  		var element = $(this).closest('.child');
    	calcul(element);
  	});

  	function calcul(element) {
	    var stock_source = element.find('.stock_source').val();
	    var paquet_source = element.find('.paquet_source').val();
	    if( stock_source == '' ) stock_source = 1;
	    if( paquet_source == '' ) paquet_source = 1;
	    var total =  parseInt(stock_source)*parseInt(paquet_source);
	    element.find('.total_general').val( total );
  	}

});
</script>
<?php $this->end() ?>