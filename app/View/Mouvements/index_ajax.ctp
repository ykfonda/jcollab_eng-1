<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Produit</th>
				<th nowrap="">Fournisseur</th>
				<th nowrap="">Numéro de lot</th>
				<th nowrap="">Date entrée</th>
				<th nowrap="">Date sortie</th>
				<th nowrap="">Quantité</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Mouvement']['reference']); ?></td>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => 'produits','action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['designation']); ?></td>
					<td nowrap=""><?php echo h($tache['Mouvement']['num_lot']); ?></td>
					<td nowrap=""><?php echo h($tache['Mouvement']['date']); ?></td>
					<td nowrap=""><?php echo h($tache['Mouvement']['date_sortie']); ?></td>
					<td nowrap=""><?php echo h($tache['Mouvement']['stock_source']); ?></td>
					<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Mouvement']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Mouvement']['id'], $tache['Mouvement']['produit_id'] ]) ?>" class="btnFlagDelete"><i class="fa fa-remove"></i> Supprimer</a>
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