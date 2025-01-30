<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
Reference, Objet, Produit, Date création, Quantité à Produire, Date Production, Quantité Produite, Num Lot, DLC, Statut, Actions


				<th nowrap="">Référence</th>
				<th nowrap="">Objet</th>
				<th nowrap="">Date OF</th>
				<th nowrap="">Dépot</th>
				<th nowrap="">Produit</th>
				<th nowrap="">Date Prod</th>
				<th nowrap="">Qtité à Prod</th>
				<th nowrap="">Qtité Produite</th>
				<th nowrap="">Num Lot</th>
				<th nowrap="">D.L.C</th>
				<th nowrap="">Statut</th>
				<th class="actions" nowrap=""></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Production']['id']]) ?>"><?php echo h($tache['Production']['reference']); ?></a></td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Production']['id']]) ?>"><?php echo h($tache['Production']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Production']['date_c']); ?></td>
					<td nowrap=""><?php echo h($tache['Depot']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Production']['date']); ?></td>
					<td nowrap="" class="text-right"><?php echo h($tache['Production']['quantite']); ?></td>
					<td nowrap="" class="text-right"><?php echo h($tache['Production']['quantite_prod']); ?></td>
					<td nowrap=""><?php echo h($tache['Production']['numlot']); ?></td>
					<td nowrap=""><?php echo h($tache['Production']['dlc']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $tache['Production']['statut'] ) ): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getValideEntreeColor($tache['Production']['statut']); ?>">
								<?php echo $this->App->getValideEntree($tache['Production']['statut']); ?>
							</span>
						<?php endif ?>
					</td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Production']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1'] AND $tache['Production']['statut'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Production']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s'] AND $tache['Production']['statut'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Production']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
			<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'))); ?>
		</div>
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