<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Fournisseur</th>
				<th nowrap="">Date</th>
				<th nowrap="">Statut</th>
				<th nowrap="">Total payé</th>
				<th nowrap="">Reste à payer</th>
				<th nowrap="">Net à payer</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
				<tr>
					<td nowrap="">
						<?php if ( $globalPermission['Permission']['m1'] ): ?>
							<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Bonreception']['id']]) ?>"><?php echo h($dossier['Bonreception']['reference']); ?></a>
						<?php else: ?>
							<?php echo h($dossier['Bonreception']['reference']); ?>
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($dossier['Fournisseur']['designation']); ?></td>
					<td nowrap=""><?php echo h($dossier['Bonreception']['date']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $dossier['Bonreception']['etat'] ) ): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatFicheColor($dossier['Bonreception']['etat']); ?>">
								<?php echo $this->App->getEtatFiche($dossier['Bonreception']['etat']); ?>
							</span>
						<?php endif ?>
					</td>
					<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonreception']['total_paye'], 2, ',', ' '); ?></td>
					<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonreception']['reste_a_payer'], 2, ',', ' '); ?></td>
					<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonreception']['total_apres_reduction'], 2, ',', ' '); ?></td>
					<td nowrap=""><?php echo h($dossier['Creator']['nom']); ?> <?php echo h($dossier['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($dossier['Bonreception']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Bonreception']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ( $globalPermission['Permission']['m1'] AND $dossier['Bonreception']['etat'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action'=>'edit',$dossier['Bonreception']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ( $globalPermission['Permission']['s'] AND $dossier['Bonreception']['etat'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Bonreception']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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