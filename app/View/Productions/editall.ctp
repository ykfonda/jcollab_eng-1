<div class="hr"></div>
<div class="card">
  <div class="card-header">
      <h4 class="card-title">Production en masse</h4>
      <div class="heading-elements">
          <ul class="list-inline mb-0">
              <li>
								<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
								<?php echo $this->Form->button('Enregistrer & Terminer',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'ProductionMasse','disabled'=>false]) ?>
              </li>
          </ul>
      </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="row">
				<div class="col-md-12">
					<?php echo $this->Form->create('Production',['id' => 'ProductionMasse','class' => 'form-horizontal']); ?>
					<div class="form-group row">
						<label class="control-label col-md-2">Objet</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
						</div>
						<label class="control-label col-md-2">Date</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-md-2">Responsable</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('user_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Responsable']); ?>
						</div>
						<label class="control-label col-md-2">Dépot</label>
						<div class="col-md-3">
							<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Dépot']); ?>
						</div>
					</div>
					<div class="form-group row row">
						<div class="col-md-12">
							<table class="table table-striped table-bordered text-center">
		          	<thead>
		              <tr>
		                  <th style="width: 30%;">Produit</th>
		                  <th nowrap="">Quantité</th>
		                  <th nowrap="" class="actions">
		                  	<?php if ($globalPermission['Permission']['a']): ?>
												 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm pull-right">
												 		<i class="fa fa-plus"></i> Ajouter un produit
												 	</button>
									      <?php endif ?>
		                  </th>                                    
		              </tr>
		          	</thead>
		            <tbody id="Main"></tbody>
		            <tbody>
		                <tr>
		                    <th style="width: 30%;"></th>
		                    <th nowrap=""></th>
		                    <th nowrap="" class="actions">
		                    	<?php if ($globalPermission['Permission']['a']): ?>
													 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm pull-right">
													 		<i class="fa fa-plus"></i> Ajouter un produit
													 	</button>
										      <?php endif ?>
		                    </th>                                    
		                </tr>
		            </tbody>
		        	</table>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){

  $('.date-picker').flatpickr({
    altFormat: "DD-MM-YYYY",
    dateFormat: "d-m-Y",
    allowInput: true,
    locale: "fr",
  });

	var Init = function(){
		$('.select2').select2();
	}

	Init();

	$('#ProductionMasse').on('submit',function(e){
		$('.saveBtn').attr('disabled',true);
	});

	async function addrow(url) {
    await $.ajax({
      url: url,
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
	}

	$('.addRow').on('click',function(e){
    e.preventDefault();
      var count = $('tbody#Main .child').length;
      if( count >= 0 ) $('.saveBtn').attr('disabled',false);
    else $('.saveBtn').attr('disabled',true);
    $('.addRow').attr('disabled',true);
    var url = $(this).attr('href')+'/'+count;
    addrow(url);
	});

	$('#Main').on('click','.deleteRow',function(e){
      e.preventDefault();
      var element = $(this);
      element.closest('.child').remove();
      var count = $('tbody#Main .child').length;
      if( count == 0 ) $('.saveBtn').attr('disabled',true);
    else $('.saveBtn').attr('disabled',false);
  });

	// $('#Main').on('change','.produit_id',function(e){
	// 	var produit_id = $(this).val();
	// 	var element = $(this);
	// 	$.ajax({
	// 	  dataType: "json",
 //      url: "<?php //echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id,
 //      success: function(dt){

 //      	if ( typeof dt.Produit.id != 'undefined' ) {
 //      		var prixachat = dt.Produit.prixachat;
 //      		element.closest('.child').find('.prix_achat').val(prixachat);
 //      	}else{
 //      		element.closest('.child').find('.prix_achat').val(0);
 //      		element.closest('.child').find('.valeur').val(0);
 //      	}

 //      },
 //      error: function(dt){
 //        toastr.error("Il y a un problème");
 //      },
 //      complete: function(){
 //      	calcule(element);
 //      }
 //    });
 //  });

  function calcule(element) {
  	var quantite = parseFloat(element.closest('.child').find('.stock_source').val());
		var prix_achat = parseFloat(element.closest('.child').find('.prix_achat').val());
		var valeur = parseFloat(quantite*prix_achat);
		element.closest('.child').find('.valeur').val(valeur);
  }

});
</script>
<?php $this->end() ?>