<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">No Commande</th>
				<th nowrap="">Client</th>
				<th nowrap="">Date</th>
				<th nowrap="">Statut</th>
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
							<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Ecommerce']['id']]) ?>"><?php echo h($dossier['Ecommerce']['barcode']); ?></a>
						<?php else: ?>
							<?php echo h($dossier['Ecommerce']['barcode']); ?>
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
					<td nowrap=""><?php echo h($dossier['Ecommerce']['date']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $dossier['Ecommerce']['etat'] ) ): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatCommandeColor($dossier['Ecommerce']['etat']); ?>">
								<?php echo $this->App->getEtatCommande($dossier['Ecommerce']['etat']); ?>
							</span>
						<?php endif ?>
					</td>
					<td nowrap="" class="text-right"><?php echo number_format($dossier['Ecommerce']['total_apres_reduction'], 2, ',', ' '); ?></td>
					<td nowrap=""><?php echo h($dossier['Creator']['nom']); ?> <?php echo h($dossier['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($dossier['Ecommerce']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Ecommerce']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ( $globalPermission['Permission']['s'] AND $dossier['Ecommerce']['etat'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Ecommerce']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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