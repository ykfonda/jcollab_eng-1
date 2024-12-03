<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php $this->end() ?>
<div class="hr"></div>

<?php if ( isset( $this->data['Bonentree']['id'] ) AND !empty( $this->data['Bonentree']['valide'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getValideEntreeColor( $this->data['Bonentree']['valide'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getValideEntreeColor( $this->data['Bonentree']['valide'] ) ?>">
        <strong>Statut bon d'entrée &ensp; : &ensp;</strong>  <?php echo $this->App->getValideEntree( $this->data['Bonentree']['valide'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">

			<?php if ( $globalPermission['Permission']['v'] AND $this->data['Bonentree']['valide'] == -1 ): ?>
				<a class="btn btn-success btnAction btn-sm" href="<?php echo $this->Html->url(['action' => 'valider', $this->data['Bonentree']['id']]) ?>"><i class="fa fa-check-square-o"></i> Valider</a>
			<?php endif ?>
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Bonentree']['id'] ) AND $this->data['Bonentree']['valide'] == -1 ): ?>
				<a class="btn btn-default edit btn-sm" href="<?php echo $this->Html->url(['action' => 'edit',0,$this->data['Bonentree']['id'] ]) ?>"><i class="fa fa-plus"></i> Ajouter produit</a>
			<?php endif ?>
		</div>
	</div>

	<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Informations Bon d'entrée
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
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap="">
                  <?php echo $this->data['Bonentree']['date'] ?>
                </td>
                <td class="tableHead" nowrap="">Depot</td>
                <td nowrap=""> 
                  <?php echo $this->data['DepotSource']['reference'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">NOMBRE DE PRODUIT(S)</td>
                <td nowrap="">
                  <?php echo count($details) ?>
                </td>
                <td class="tableHead" nowrap=""></td>
                <td nowrap="">
                
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
								<th nowrap="">Date entrée</th>
								<th nowrap="">Date sortie</th>
								<th nowrap="">Dépot</th>
								<th nowrap="">Quantité</th>
								<th nowrap="">Prix d'achat</th>
								<th nowrap="">Valeur du stock</th>
								<th nowrap="">Numéro de lot</th>
								<?php if ( isset( $this->data['Bonentree']['valide'] ) AND $this->data['Bonentree']['valide'] == -1 ): ?>
								<th class="actions">Actions</th>
								<?php endif ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $tache): ?>
								<?php $controller = ( isset( $tache['Produit']['id'] ) AND $tache['Produit']['type'] == 1 ) ? 'recettes' : 'ingredients' ; ?>
								<tr>
									<td nowrap=""><?php echo h($tache['Bonentreedetail']['reference']); ?></td>
									<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => $controller,'action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
									<td nowrap=""><?php echo h($tache['Bonentreedetail']['date']); ?></td>
									<td nowrap=""><?php echo h($tache['Bonentreedetail']['date_sortie']); ?></td>
									<td nowrap=""><?php echo h($tache['DepotSource']['libelle']); ?></td>
									<td nowrap=""><?php echo h($tache['Bonentreedetail']['stock_source']); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prixachat'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prixachat']*$tache['Bonentreedetail']['stock_source'], 2, ',', ' ') ?></td>
									<td nowrap=""><?php echo h($tache['Bonentreedetail']['num_lot']); ?></td>
									<?php if ( isset( $this->data['Bonentree']['valide'] ) AND $this->data['Bonentree']['valide'] == -1 ): ?>
									<td nowrap="" class="actions">
										<?php if ($globalPermission['Permission']['m1'] ): ?>
											<a class="btn btn-success edit btn-xs" href="<?php echo $this->Html->url(['action' => 'edit',$tache['Bonentreedetail']['id'],$tache['Bonentreedetail']['bonentree_id'] ]) ?>"><i class="fa fa-edit"></i> Modifier</a>
										<?php endif ?>
										<?php if ($globalPermission['Permission']['s'] ): ?>
											<a class="btn btn-danger btnAction btn-xs" href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Bonentreedetail']['id']]) ?>"><i class="fa fa-remove"></i> Supprimer</a>
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
});
</script>
<?php $this->end() ?>

















