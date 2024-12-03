<div class="table-scrollable">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Date</th>
				<th nowrap="">Dépot</th>
				<th nowrap="">Nombre de produit(s)</th>
				<th nowrap=""></th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Bonentree']['id']]) ?>"><?php echo h($tache['Bonentree']['reference']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Bonentree']['date']); ?></td>
					<td nowrap=""><?php echo h($tache['DepotSource']['libelle']); ?></td>
					<td nowrap=""><?php echo count($tache['Bonentreedetail']); ?> produit(s)</td>
					<td nowrap="">
						<a class="btn btn-warning btn-xs" href="<?php echo $this->Html->url(['action' => 'view', $tache['Bonentree']['id']]) ?>"><i class="fa fa-eye"></i> Voir détail</a>
					</td>
					<td nowrap="" class="actions">
						<?php if ( $tache['Bonentree']['valide'] == -1 ): ?>
							<?php if ($globalPermission['Permission']['v'] ): ?>
								<a data-action="valider" class="btn btn-success btnFlagValider btn-xs" href="<?php echo $this->Html->url(['action' => 'valider', $tache['Bonentree']['id']]) ?>"><i class="fa fa-check"></i> Valider</a>
							<?php endif ?>
							<?php if ($globalPermission['Permission']['s'] ): ?>
								<a data-action="supprimer" class="btn btn-danger btnFlagDelete btn-xs" href="<?php echo $this->Html->url(['action' => 'delete', $tache['Bonentree']['id']]) ?>"><i class="fa fa-remove"></i> Supprimer</a>
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