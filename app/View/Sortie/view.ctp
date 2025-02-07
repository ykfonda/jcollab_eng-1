<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php $this->end() ?>
<div class="hr"></div>

<?php if ( isset( $this->data['Mouvementprincipal']['id'] ) AND !empty( $this->data['Mouvementprincipal']['valide'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Mouvementprincipal']['valide'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getValideEntreeColor( $this->data['Mouvementprincipal']['valide'] ) ?>">
        <strong>Statut sortie de stock &ensp; : &ensp;</strong>  <?php echo $this->App->getValideEntree( $this->data['Mouvementprincipal']['valide'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>


	<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
  <?php // if ($this->data['Mouvementprincipal']['type'] == "Expedition") : ?>
  <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Mouvementprincipal']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
  <?php // endif ?> 
  <?php if ( $globalPermission['Permission']['v'] AND $this->data['Mouvementprincipal']['valide'] == -1 ): ?>
				<a class="btn btn-success btnAction btn-sm" href="<?php echo $this->Html->url(['action' => 'valider', $this->data['Mouvementprincipal']['id']]) ?>"><i class="fa fa-check-square-o"></i> Valider</a>
			<?php endif ?>
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Mouvementprincipal']['id'] ) AND $this->data['Mouvementprincipal']['valide'] == -1 ): ?>
				<a class="btn btn-success edit btn-sm" href="<?php echo $this->Html->url(['action' => 'edit',0,$this->data['Mouvementprincipal']['id'] ]) ?>"><i class="fa fa-plus"></i> Ajouter produit</a>
			<?php endif ?>

  </div>
</div>


	<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Informations sortie
    </div>
    <div class="actions">
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable" >
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Date Sortie</td>
                <td nowrap="">
                  <?php echo $this->data['Mouvementprincipal']['date_sortie'] ?>
                </td>
                <td class="tableHead" nowrap="">Depôt Source</td>
                <td nowrap=""> 
                  <?php echo $this->data['DepotSource']['reference'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Nombre de produit (s)</td>
                <td nowrap="">
                  <?php echo $this->data['Mouvementprincipal']['nb_produits'] ?>
                </td>
                <td class="tableHead" nowrap="">Type de sortie</td>
                <td nowrap="">
                  <?php echo $this->data['Mouvementprincipal']['type'] ?>
                </td>
              </tr>

			  <tr>
                <td class="tableHead" nowrap="">Motif</td>
                <td nowrap="">
				<?php echo isset($this->data['Motifsretour']['libelle']) ? h($this->data['Motifsretour']['libelle']) : 'Non spécifié'; ?>
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

    </div>
  </div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Produit</th>
								<th nowrap="">Date sortie</th>
								<th nowrap="">Dépot source</th>
								<?php if (  $this->data['Mouvementprincipal']['type'] == "Expédition") : ?>
								<th nowrap="">Dépot destination</th>
								
								<?php endif ?>
								<th nowrap="">Quantité sortie</th>

								<?php
								$Mouvementprincipal_type = $this->data['Mouvementprincipal']['type'];
									if ($Mouvementprincipal_type == "Expedition") {
								?>
										<th nowrap="">Quantité validée (destination)</th>
								<?php
									}
								?>
										
								<?php if ( isset( $this->data['Mouvementprincipal']['valide'] ) AND $this->data['Mouvementprincipal']['valide'] == -1 ): ?>
								<th class="actions">Actions</th>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $tache): ?>
								<?php $controller = ( isset( $tache['Produit']['id'] ) AND $tache['Produit']['type'] == 1 ) ? 'recettes' : 'ingredients' ; ?>
								<tr>
									<td nowrap=""><?php echo h($tache['Sortiedetail']['reference']); ?></td>
									<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => $controller,'action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
									<td nowrap=""><?php echo h($tache['Sortiedetail']['date']); ?></td>
									<td nowrap=""><?php echo h($tache['DepotSource']['libelle']); ?></td>
									<?php if (  $this->data['Mouvementprincipal']['type'] == "Expédition") : ?>
									<td nowrap=""><?php echo h($tache['DepotDestination']['libelle']); ?></td>
									<?php endif ?>
									<td nowrap="" class="text-right">
										<?php echo h($tache['Sortiedetail']['stock_source']); ?>
									</td>
									
									<?php

										if ($Mouvementprincipal_type == "Expedition" AND !empty($tache['Mouvementprincipal']['Bonreception']) AND $tache['Mouvementprincipal']['Bonreception'][0]['etat'] ==2 AND isset($tache['Mouvementprincipal']['Bonreception']) ) {

										$produi_id_db 			= $tache['Produit']['id'];
										$Bonreceptiondetail_db 	= $tache['Mouvementprincipal']['Bonreception'][0]['Bonreceptiondetail'];
										$qte_sortie 			= $tache['Sortiedetail']['stock_source'];
										
									echo '<td nowrap="" class="text-right">';
												
											// Parcourir les éléments du tableau
											foreach ($Bonreceptiondetail_db as $bonreceptiondetail) {

												$bonreceptiondetail_id = $bonreceptiondetail['id'];
												$bonreceptiondetail_produit_db = $bonreceptiondetail['produit_id'];
												$bonreceptiondetail_qte_db = $bonreceptiondetail['qte'];

												// Ajouter le style selon le résultat de la comparaison entre les deux quantité
												if ($qte_sortie > $bonreceptiondetail_qte_db) {
													$class_devi ="text-danger";
												}
												if ($qte_sortie < $bonreceptiondetail_qte_db) {
													$class_devi ="text-success";
												}
												if ($qte_sortie == $bonreceptiondetail_qte_db) {
													$class_devi ="text-dark";
												}

												if ($produi_id_db == $bonreceptiondetail_produit_db) {
													echo "<span class=".$class_devi.">".$bonreceptiondetail_qte_db."</span>";
												}
												
											}
									
										echo '</td>';
										}else{
											echo '<td nowrap="" class="text-right">';
											echo '<span class="text-dark"> 0.000 </span>';
											echo '</td>';
										}
									?>

									<?php if ( isset( $this->data['Mouvementprincipal']['valide'] ) AND $this->data['Mouvementprincipal']['valide'] == -1 ): ?>
									<td nowrap="" class="actions">
										<?php if ($globalPermission['Permission']['m1'] ): ?>
											<a class="btn btn-success edit btn-xs" href="<?php echo $this->Html->url(['action' => 'edit',$tache['Sortiedetail']['id'],$tache['Sortiedetail']['id_mouvementprincipal'] ]) ?>"><i class="fa fa-edit"></i> Modifier</a>
										<?php endif ?>
										<?php if ($globalPermission['Permission']['s'] ): ?>
											<a class="btn btn-danger btnSupp btn-xs" href="<?php echo $this->Html->url(['action' => 'delete', $tache['Sortiedetail']['id'], $tache['Sortiedetail']['id_mouvementprincipal']]) ?>"><i class="fa fa-remove"></i> Supprimer</a>
										<?php endif ?>
									</td>
									<?php endif ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

	      	</div>
	    </div>
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
	$('.btnSupp').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
  	});  
	  
	 
});
</script>
<?php $this->end() ?>

















