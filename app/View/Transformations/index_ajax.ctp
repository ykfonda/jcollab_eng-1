<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Réf</th>
				<th nowrap="">Objet</th>
				<th nowrap="">Date</th>
				<th nowrap="">Responsable</th>
				<th nowrap="">Dépot</th>
				<th nowrap="">Statut</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap=""></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Transformation']['id']]) ?>"><?php echo h($tache['Transformation']['reference']); ?></a></td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Transformation']['id']]) ?>"><?php echo h($tache['Transformation']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Transformation']['date']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?> <?php echo h($tache['User']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Depot']['libelle']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $tache['Transformation']['statut'] ) ): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getValideEntreeColor($tache['Transformation']['statut']); ?>">
								<?php echo $this->App->getValideEntree($tache['Transformation']['statut']); ?>
							</span>
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($tache['Transformation']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Transformation']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1'] AND $tache['Transformation']['statut'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Transformation']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s'] AND $tache['Transformation']['statut'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Transformation']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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