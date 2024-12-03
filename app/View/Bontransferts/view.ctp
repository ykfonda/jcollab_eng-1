<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php $this->end() ?>


<?php if ( isset( $this->data['Bontransfert']['id'] ) AND !empty( $this->data['Bontransfert']['valide'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Bontransfert']['valide'] ) ?>;padding:10px;border-color: <?php echo $this->App->getValideEntreeColor( $this->data['Bontransfert']['valide'] ) ?>">
        <strong>Statut bon de transfert &ensp; : &ensp;</strong>  <?php echo $this->App->getValideEntree( $this->data['Bontransfert']['valide'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
		
  <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ( $globalPermission['Permission']['v'] AND $this->data['Bontransfert']['valide'] == -1  AND $this->data['Bontransfert']['type'] == "Expedition" ): ?>
				<a class="btn btn-success  btnFlagValiderExp btn-sm" href="<?php echo $this->Html->url(['action' => 'validerExp', $this->data['Bontransfert']['id']]) ?>"><i class="fa fa-check-square-o"></i> Valider</a>
			<?php elseif($globalPermission['Permission']['v'] AND $this->data['Bontransfert']['valide'] == -1  AND $this->data['Bontransfert']['type'] != "Expedition") : ?>
      <a class="btn btn-success btnAction btn-sm" href="<?php echo $this->Html->url(['action' => 'valider', $this->data['Bontransfert']['id']]) ?>"><i class="fa fa-check-square-o"></i> Valider</a>
      <?php endif ?>
		</div>
	</div>







<?php if ( isset( $this->data['Bontransfert']['id'] ) AND !empty( $this->data['Bontransfert']['id'] ) ): ?>





<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Bon transfert
    </div>
    <div class="actions">
      
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Bontransfert']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date transfert</td>
                <td nowrap=""> 
                  <?php echo $this->data['Bontransfert']['date'] ?>
                </td>
              </tr>
              
              <tr>
              
                <td class="tableHead" nowrap="">Dépot Source</td>
                
                <td nowrap="">
            
                  <?php echo $this->data['DepotSource']['libelle'] ?>
                </td>

				<td class="tableHead" nowrap="">Dépot Destination</td>
                
                <td nowrap="">
                
                  <?php echo $this->data['DepotDestination']['libelle'] ?>
                 
                </td>
                  
              </tr>

              <tr>
                
                <td class="tableHead" nowrap="">Statut</td>
                <td nowrap="" >
                  <?php if ( $this->data['Bontransfert']['valide'] == -1 ): ?>
                    <div class="badge badge-default" style="color:white;width: 100%;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bontransfert']['valide'] ) ?>;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bontransfert']['valide'] ) ?>"><?php echo $this->App->getEtatFiche( $this->data['Bontransfert']['valide'] ) ?>
                    </div>
					<?php else : ?>
						<div class="badge badge-default" style="color:white;width: 100%;background-color: <?php echo $this->App->getEtatFicheColor( 2 ) ?>;border-color: <?php echo $this->App->getEtatFicheColor( 2 ) ?>"><?php echo $this->App->getEtatFiche( 2 ) ?>
                    </div>
                  <?php endif ?>
                </td>
				<td class="tableHead" nowrap="">Total à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Bontransfert']['total'], 2, ',', ' '); ?>
                </td>
              </tr>



            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Liste des produits
    </div>
    <div class="actions">
    <?php if($this->data['Bontransfert']['type'] != "Expedition") :?>
      
      <?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Bontransfert']['id'] ) AND $this->data['Bontransfert']['valide'] == -1 AND ($this->data['Bontransfert']['type'] != "Expedition")): ?>
        <a class="edit btn btn-primary btn-sm" href="<?php echo $this->Html->url(['action' => 'edit',0,$this->data['Bontransfert']['id'] ]) ?>"><i class="fa fa-plus"></i> Ajouter produit</a>
			<?php endif ?>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Qté cmd</th>
                <?php if($this->data['Bontransfert']['type'] == "Expedition") :?>
                <th nowrap="">Qté reçu</th>
                <?php endif ?>
                <th nowrap="">PRIX DE VENTE TTC</th>
				<th nowrap="">Valeur du stock</th>
                
       
                <?php if ( $this->data['Bontransfert']['valide'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Bontransfertdetail']['stock_source'], 3, ',', ' ') ?></td>
                  <?php if($this->data['Bontransfert']['type'] == "Expedition") :?>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Bontransfertdetail']['stock_destination'], 3, ',', ' ') ?></td>
                  <?php endif ?>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prix_vente'], 2, ',', ' '); ?></td>
                  <?php if($this->data['Bontransfert']['type'] == "Expedition") :?>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prixachat']*$tache['Bontransfertdetail']['stock_destination'], 2, ',', ' ') ?></td>
                  <?php else: ?>
                    <td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prixachat']*$tache['Bontransfertdetail']['stock_source'], 2, ',', ' ') ?></td>
                    <?php endif ?>
				  <?php if ( $this->data['Bontransfert']['valide'] == -1 ): ?> 
				  <td nowrap="" class="actions">
                  
					<?php if ( isset( $this->data['Bontransfert']['valide'] ) AND $this->data['Bontransfert']['valide'] == -1 ): ?>
											<?php if ($globalPermission['Permission']['m1'] ): ?>
												<a class="btn btn-success edit btn-xs" href="<?php echo $this->Html->url(['action' => 'edit',$tache['Bontransfertdetail']['id'],$tache['Bontransfertdetail']['bontransfert_id'] ]) ?>"><i class="fa fa-edit"></i> Modifier</a>
											<?php endif ?>
											<?php if ($globalPermission['Permission']['s'] ): ?>
												<a class="btn btn-danger btnAction btn-xs" href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Bontransfertdetail']['id'],$tache['Bontransfertdetail']['bontransfert_id']]) ?>"><i class="fa fa-remove"></i> Supprimer</a>
											<?php endif ?>
										<?php else: ?>
											<span class="badge badge-success" style="width: 100%;"> Validé </span>
										<?php endif ?>
                  <?php endif ?>
				  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php endif ?>
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

	    if ( $('#RecordID').val() != '' ) {
		    var depot_id = $('#DepotSource').val();
	  		var produit_id = $('.produit_id').val();
	  		loadQuatite(depot_id,produit_id);
	    }
  	}

  	Init();

  	$('#edit').on('change','.produit_id',function(e){
  		var depot_id = $('#DepotSource').val();
  		var produit_id = $('.produit_id').val();
  		loadQuatite(depot_id,produit_id);
  	});

  	$('#edit').on('change','.produit_id',function(e){
	    var produit_id = $(this).val();
	    //loadDepots(produit_id);
  	});
	  $('#edit').on('submit','#Validerexp',function(e){
  $("#Validerexp").submit();
});
  	function loadDepots(produit_id) {
	    $.ajax({
	      dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loaddepots']) ?>/"+produit_id,
	      success: function(dt){
	        var value = $('#DepotSource').val();
	        $('#DepotSource').empty();
	        $('#DepotSource').append($('<option>').text('-- Dépôt source').attr('value', ''));
	        $.each(dt, function(i, obj){
	          $('#DepotSource').append($('<option>').text(obj).attr('value', i));
	        });

	        $('#DepotSource').trigger('change');
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      }
	    }); 
	}

  	function loadQuatite(depot_id,produit_id,element) {
	    $.ajax({
	      dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadquatite']) ?>/"+depot_id+"/"+produit_id,
	      success: function(dt){
	        if ( dt >= 0 ) {
	        	$('.stock_source').attr({ "max" : dt });
		        $('.stock').val( dt );
	        }
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      }
	    }); 
	}

  	$('#edit').on('submit','form',function(e){
		$('.saveBtn').attr('disabled',true);
	});
  
  	$('.edit').on('click',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un probleme");
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	});

  	$('.btnAction').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
  	});

	$('.btnFlagValiderExp').on('click',function(e){
		
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
		$('.select2').select2();
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });

});
</script>
<?php $this->end() ?>

