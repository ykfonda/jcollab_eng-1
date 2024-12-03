<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover " cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Code à barre</th>
				<th nowrap="">Produit</th>
				<th nowrap="">Depôt</th>
		        <th nowrap="">Stock actuel</th>
		        <th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<?php $controller = ( isset( $tache['Produit']['id'] ) AND $tache['Produit']['type'] == 1 ) ? 'recettes' : 'ingredients' ; ?>
				<tr>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => $controller,'action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['reference']); ?></a></td>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => $controller,'action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['code_barre']); ?></a></td>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => $controller,'action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Depot']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Depotproduit']['quantite']); ?></td>
					<th class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Depotproduit']['id']]) ?>" class="edit"><i class="fa fa-edit"></i> Ajuster</a>
						<?php endif ?>
					</th>
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