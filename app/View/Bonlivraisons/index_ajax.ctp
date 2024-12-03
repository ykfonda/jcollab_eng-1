<?php $total_paye = 0; $reste_a_payer = 0; $total_apres_reduction = 0; ?>
<?php foreach ($bonlivraisons as $v): ?>
	<?php $total_paye = $total_paye + $v['Bonlivraison']['total_paye']; ?>
	<?php $reste_a_payer = $reste_a_payer + $v['Bonlivraison']['reste_a_payer']; ?>
	<?php $total_apres_reduction = $total_apres_reduction + $v['Bonlivraison']['total_apres_reduction']; ?>
<?php endforeach ?>
<div class="table-scrollable" style="height: 450px;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Client</th>
				<th nowrap="">Vendeur</th>
				<th nowrap="">Date</th>
				<th nowrap="">Etat</th>
				<th nowrap="">Remise (%)</th>
				<th nowrap="">Total payé</th>
				<th nowrap="">Reste à payer</th>
				<th nowrap="">Net à payer</th>
				<th nowrap="">Statut</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
			<tr>
				<td nowrap="">
					<?php if ( $globalPermission['Permission']['m1'] ): ?>
						<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Bonlivraison']['id']]) ?>"><?php echo h($dossier['Bonlivraison']['reference']); ?></a>
					<?php else: ?>
						<?php echo h($dossier['Bonlivraison']['reference']); ?>
					<?php endif ?>
				</td>
				<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
				<td nowrap=""><?php echo h($dossier['User']['nom']); ?> <?php echo h($dossier['User']['prenom']); ?></td>
				<td nowrap=""><?php echo h($dossier['Bonlivraison']['date']); ?></td>
				<td nowrap="">
					<?php if ( !empty( $dossier['Bonlivraison']['etat'] ) ): ?>
						<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatFicheColor($dossier['Bonlivraison']['etat']); ?>">
							<?php echo $this->App->getEtatFiche($dossier['Bonlivraison']['etat']); ?>
						</span>
					<?php endif ?>
				</td>
				<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['remise'], 2, ',', ' '); ?>%</td>
				<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['total_paye'], 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['reste_a_payer'], 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['total_apres_reduction'], 2, ',', ' '); ?></td>
				<td nowrap="">
					<?php if ( !empty($dossier['Bonlivraison']['paye']) ): ?>
						<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($dossier['Bonlivraison']['paye']); ?>">
							<?php echo $this->App->getStatutPayment($dossier['Bonlivraison']['paye']); ?>
						</span>
					<?php endif ?>
				</td>
				<td nowrap="" class="actions">
					<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Bonlivraison']['id']]) ?>"><i class="fa fa-eye"></i></a>
					<?php if ( $dossier['Bonlivraison']['etat'] != 2 ): ?>
					<?php if ( $globalPermission['Permission']['m1'] ): ?>
						<a href="<?php echo $this->Html->url(['action'=>'edit',$dossier['Bonlivraison']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
					<?php endif ?>
					<?php endif ?>
					<?php if ( $globalPermission['Permission']['s'] AND $dossier['Bonlivraison']['etat'] == -1 ): ?>
						<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Bonlivraison']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
					<?php endif ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td nowrap="" class="text-right"><b><?php echo number_format($total_paye, 2, ',', ' '); ?></b></td>
				<td nowrap="" class="text-right"><b><?php echo number_format($reste_a_payer, 2, ',', ' '); ?></b></td>
				<td nowrap="" class="text-right"><b><?php echo number_format($total_apres_reduction, 2, ',', ' '); ?></b></td>
				<td></td>
				<td></td>
				<td class="actions"></td>
				<td class="actions"></td>
			</tr>
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