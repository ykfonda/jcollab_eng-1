<div class="table-scrollable" style="height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Ticket</th>
				<th nowrap="">Client</th>
				<th nowrap="">Vendeur</th>
				<th nowrap="">Date</th>
				<th nowrap="">Etat</th>
				<th nowrap="">Type</th>
				<th nowrap="">Mode</th>
				<th nowrap="">Remise (%)</th>
				<th nowrap="">Total payé</th>
				<th nowrap="">Reste à payer</th>
				<th nowrap="">Net à payer</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th nowrap="">Statut</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
				<?php $total_paye = 0;
                    foreach ($dossier['Avance'] as $avance) {
                        $total_paye += $avance['montant'];
                    }
                    $net_a_payer = $dossier['Salepoint']['total_a_payer_ttc'] - $dossier['Salepoint']['montant_remise'] + $dossier['Salepoint']['fee'];     
                ?>
			<tr>
				<td nowrap="">
					<?php if ($globalPermission['Permission']['m1']): ?>
						<?php if ($dossier['Salepoint']['msg_api'] == 'probleme Api'): ?>
							<a style="color: red;" href="<?php echo $this->Html->url(['action' => 'view', $dossier['Salepoint']['id']]); ?>"><?php echo h($dossier['Salepoint']['reference']); ?></a>
							
							<?php else: ?>
								<a  href="<?php echo $this->Html->url(['action' => 'view', $dossier['Salepoint']['id']]); ?>"><?php echo h($dossier['Salepoint']['reference']); ?></a>			
						<?php endif; ?>
						
					<?php else: ?>
						
					<?php echo h($dossier['Salepoint']['reference']); ?>
					<?php endif; ?>
				</td>
				<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
				<td nowrap=""><?php echo h($dossier['User']['nom']); ?> <?php echo h($dossier['User']['prenom']); ?></td>
				<td nowrap=""><?php echo h($dossier['Salepoint']['date']); ?></td>
				<td nowrap="">
				<?php $net_a_payer = $dossier['Salepoint']['total_a_payer_ttc'] - $dossier['Salepoint']['montant_remise'] + $dossier['Salepoint']['fee'];
                  $total_paye = $total_paye;
                  if ($net_a_payer == $total_paye) {
                      $paye = 2;
                  } elseif ($total_paye == 0) {
                      $paye = -1;
                  } elseif ($net_a_payer > $total_paye) {
                      $paye = 1;
                  } elseif ($net_a_payer < $total_paye) {
                      $paye = 2;
                  } ?>
					<?php if (!empty($dossier['Salepoint']['etat'])): ?>
						<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatFicheColor($dossier['Salepoint']['etat']); ?>">
							<?php echo $this->App->getEtatFiche($dossier['Salepoint']['etat']); ?>
						</span>
					<?php endif; ?>
				</td>


				<?php 
					$glovo_id_db 		= $dossier['Salepoint']['glovo_id'];
					$ecommerce_id_db 	= $dossier['Salepoint']['ecommerce_id'];
					$type_vente 		= "DIRECTE"; // Valeur par default
					$style_back_type_vente = "";

					if (isset($glovo_id_db) && !empty($glovo_id_db)) {
						$type_vente = "GLOVO";
						$style_back_type_vente =  'style="background: #F6C71F;"';
					}
			
					if (isset($ecommerce_id_db) && !empty($ecommerce_id_db)) {
						$type_vente = "ECOM";
						$style_back_type_vente =  'style="background: #bbf5ff;"';
					}
				?>
				<td nowrap="" <?php echo $style_back_type_vente; ?> >
					<?php					
						echo $type_vente;
					?>
				</td>

				<td nowrap="" >
					<?php
						foreach ($dossier['Avance'] as $avance) {
							$mode_paiement = $avance['mode'];
							echo $mode_paiement." | ";
						} 
					?>
				</td>





				<td nowrap="" class="text-right"><?php echo number_format($dossier['Salepoint']['remise'], 2, ',', ' '); ?>%</td>
				
				<td nowrap="" class="text-right"><?php echo number_format($total_paye, 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right"><?php echo number_format($dossier['Salepoint']['reste_a_payer'], 2, ',', ' '); ?></td>
				<td nowrap="" class="text-right"><?php echo number_format(/* $dossier['Salepoint']['total_apres_reduction'] + $dossier['Salepoint']['fee'] */$net_a_payer, 2, ',', ' '); ?></td>
				<td nowrap=""><?php echo h($dossier['Creator']['nom']); ?> <?php echo h($dossier['Creator']['prenom']); ?></td>
				<td nowrap=""><?php echo h($dossier['Salepoint']['date_c']); ?></td>
				<td nowrap="">
					<?php if (!empty($dossier['Salepoint']['paye'])): ?>
						<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($dossier['Salepoint']['paye']); ?>">
							<?php echo $this->App->getStatutPayment($dossier['Salepoint']['paye']); ?>
						</span>
					<?php endif; ?>
				</td>
				<td nowrap="" class="actions">
					<a href="<?php echo $this->Html->url(['action' => 'view', $dossier['Salepoint']['id']]); ?>"><i class="fa fa-eye"></i></a>
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