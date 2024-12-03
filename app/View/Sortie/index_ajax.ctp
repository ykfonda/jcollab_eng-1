<div class="table-responsive">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Date</th>
				<th nowrap="">Source</th>
				<th nowrap="">Destination</th>
				<th nowrap="">Nbr produit</th>
				<th nowrap="">Type</th>
				<th nowrap="">Motif</th>
				<th nowrap="">Détail</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($mouvementprincipals as $mouvementprincipal): ?>
				<tr>
					<td nowrap=""><?php echo h($mouvementprincipal['Mouvementprincipal']['reference']); ?></td>
					<td nowrap=""><?php echo date("d-m-Y", strtotime($mouvementprincipal['Mouvementprincipal']['date_sortie'])); ?></td>
					<td nowrap=""><?php echo h($mouvementprincipal['DepotSource']['libelle']); ?></td>
					<td nowrap=""><?php echo h($mouvementprincipal['DepotDestination']['libelle']); ?></td>
					<td><?php echo ($mouvementprincipal["Mouvementprincipal"]["nb_produits"]); ?> produit(s)</td>
					<td nowrap=""><?php echo h($mouvementprincipal['Mouvementprincipal']['type']); ?></td>
					<td nowrap=""><?php echo h($mouvementprincipal['Mouvementprincipal']['description']); ?></td>
					<td nowrap="">
					<a class="btn btn-warning btn-xs" href="<?php echo $this->Html->url(['action' => 'view', $mouvementprincipal['Mouvementprincipal']['id']]) ?>"><i class="fa fa-eye"></i> Voir détail</a>
					</td>
				    <td nowrap="" class="actions">
					<?php if ( $mouvementprincipal['Mouvementprincipal']['valide'] == -1 ): ?>
						<?php if ($globalPermission['Permission']['v'] ): ?>
							<a data-action="valider" class="btn btn-success btnFlagValider btn-xs" href="<?php echo $this->Html->url(['action' => 
'valider', $mouvementprincipal['Mouvementprincipal']['id'], $mouvementprincipal['Mouvementprincipal']['depot_destination_id'], $mouvementprincipal['Mouvementprincipal']['depot_source_id']]) ?>"><i class="fa fa-check"></i> Valider</a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s'] ): ?>
							<a data-action="supprimer" class="btn btn-danger btnFlagDeleteSortie btn-xs" href="<?php echo $this->Html->url(['action' => 'delete_principal', $mouvementprincipal['Mouvementprincipal']['id']]) ?>"><i class="fa fa-remove"></i> Supprimer</a>
						<?php endif ?>
					<?php else: ?>
						<span class="badge badge-success" style="width: 100%;"> Validé </span>
					<?php endif ?>
					</td> 
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
		echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')
		)); ?></div>
	</div>
	<div class="col-md-7 col-sm-12">
		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
			<ul class="pagination">
				<?php 
				    echo $this->Paginator->prev( '<', array( 'class' => 'page-link', 'tag' => 'li' ), null,  array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				    echo $this->Paginator->numbers( array( 'class' => 'page-link', 'tag' => 'li', 'separator' => '', 'currentClass' => 'page-link active', 'currentTag' => 'a' ) );
				    echo $this->Paginator->next( '>', array( 'class' => 'page-link', 'tag' => 'li' ), null, array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				?>
			</ul>
		</div>
	</div>
</div>

<script>
$(function(){
	$('.btnFlagValider').on('click',function(e){
		e.preventDefault();
		var url = $(this).prop('href');
		bootbox.confirm("Etes-vous sûr de vouloir confirmer la validation ?", function(result) {
		if( result ){
			window.location = url;
		}
    });
  });
  	$('.btnFlagDeleteSortie').on('click',function(e){
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
