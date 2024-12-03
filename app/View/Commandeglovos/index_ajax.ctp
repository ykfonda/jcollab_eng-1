<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">No Commande</th>
				<th nowrap="">Client</th>
				<th nowrap="">Date</th>
				<th nowrap="">Statut</th>
				<th nowrap="">Net à payer</th>
				<th nowrap="">Prete pour livraison</th>
				<th nowrap="">Prise par le client</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
				<tr>
					<td nowrap="">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'view', $dossier['Commandeglovo']['id']]); ?>"><?php echo h($dossier['Commandeglovo']['order_code']); ?></a>
						<?php else: ?>
							<?php echo h($dossier['Commandeglovo']['order_code']); ?>
						<?php endif; ?>
					</td>
					<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
					<td nowrap=""><?php echo h($dossier['Commandeglovo']['date']); ?></td>
					<td nowrap="">
						<?php if (!empty($dossier['Commandeglovo']['etat'])): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatCommandeColor($dossier['Commandeglovo']['etat']); ?>">
								<?php echo $this->App->getEtatCommandeGlovo($dossier['Commandeglovo']['etat']); ?>
							</span>
						<?php endif; ?>
					</td>
					<td nowrap="" class="text-right"><?php echo number_format($dossier['Commandeglovo']['total_apres_reduction'], 2, ',', ' '); ?></td>
					
					<td nowrap="" class="text-center">
						<?php if ((!isset($dossier['Commandeglovo']['api_OUT_FOR_DELIVERY']) or ($dossier['Commandeglovo']['api_OUT_FOR_DELIVERY'] == 'erreur')) and (($dossier['Commandeglovo']['is_picked_up_by_customer'] == false) and $dossier['Commandeglovo']['etat'] != 3)) : ?>
							
					<a  href="<?php echo $this->Html->url(['action' => 'Apiglovo', $dossier['Commandeglovo']['id'], 'OUT_FOR_DELIVERY']); ?>" class="PretePourlivraison"><i style="font-size : 150%" class="fa-solid fa-motorcycle"></i></a>
					<?php endif; ?></td>
					
					<td nowrap="" class="text-center">
					<?php if ((!isset($dossier['Commandeglovo']['api_PICKED_UP_BY_CUSTOMER']) or ($dossier['Commandeglovo']['api_PICKED_UP_BY_CUSTOMER'] == 'erreur')) and (($dossier['Commandeglovo']['is_picked_up_by_customer'] == true) and $dossier['Commandeglovo']['etat'] != 3)) : ?>
						<a href="<?php echo $this->Html->url(['action' => 'Apiglovo', $dossier['Commandeglovo']['id'], 'PICKED_UP_BY_CUSTOMER']); ?>" class="PretePourlivraison"><i style="line-height : unset !important;font-size : 160%" class="fa-solid fa-user-check"></i></a>
						<?php endif; ?>	</td>
						<td nowrap=""><?php echo 'Glovo'; ?> </td>
					<td nowrap=""><?php echo h($dossier['Commandeglovo']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $dossier['Commandeglovo']['id']]); ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['s'] and $dossier['Commandeglovo']['etat'] == -1): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Commandeglovo']['id']]); ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif; ?>
					</td>
					
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
			<?php echo $this->Paginator->counter(['format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')]); ?>
		</div>
	</div>
	<div class="col-md-7 col-sm-12">
		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
			<ul class="pagination">
				<?php
                    echo $this->Paginator->prev('<', ['class' => 'page-link', 'tag' => 'li'], null, ['class' => 'page-link disabled', 'tag' => 'li', 'disabledTag' => 'a']);
                    echo $this->Paginator->numbers(['class' => 'page-link', 'tag' => 'li', 'separator' => '', 'currentClass' => 'page-link active', 'currentTag' => 'a']);
                    echo $this->Paginator->next('>', ['class' => 'page-link', 'tag' => 'li'], null, ['class' => 'page-link disabled', 'tag' => 'li', 'disabledTag' => 'a']);
                ?>
			</ul>
		</div>
	</div>
</div>

