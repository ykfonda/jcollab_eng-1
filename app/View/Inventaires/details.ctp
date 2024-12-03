<div class="table-scrollable smallFormView">
	<table class="table table-striped table-bordered table-hover " cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Code</th>
				<th nowrap="">Article</th>
				<th nowrap="">Prix de vente</th>

				<th nowrap="">valstkini</th>

		        <th nowrap="">Stock théorique</th>
		        <th nowrap="">Stock réel</th>
				<th nowrap="">Ecart</th>

				<th nowrap="">valentree</th>
				<th nowrap="">qtentree</th>

				<th nowrap="">valsortie</th>
				<th nowrap="">qtsortie</th>

				<th nowrap="">valvente</th>
				<th nowrap="">qtvente</th>
				
		        <th nowrap="">Ecart valorisé (PA)</th>
		        <th nowrap="">Valeur du stock réel (PA)</th>
		        <?php if (isset($inventaire['Inventaire']['statut']) and $inventaire['Inventaire']['statut'] == -1): ?>
		        <!-- <th class="actions" nowrap=""> -->
		        <?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): 	
			$type_data_inv = $tache['Inventairedetail']['type_data']; // 0 import or 1 calc	
			?>

				<tr <?php if ($type_data_inv == 1) echo 'style="background-color: #b5f1f7;"'; ?>>
					<td nowrap="" class="text-right"><?php echo $tache['Produit']['code_barre']; ?></td>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => 'produits', 'action' => 'view', $tache['Produit']['id']]); ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
					
					<td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prix_vente'], 2, ',', ' '); ?></td>

					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['valstkini']); ?></td>

					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['quantite_theorique']); ?></td>
					
					<td nowrap="">
						<?php echo $this->Form->hidden('Inventairedetail.'.$tache['Inventairedetail']['id'].'.id', ['value' => $tache['Inventairedetail']['id'], 'form' => 'DetailForm']); ?>
						<?php echo $this->Form->hidden('Inventairedetail.'.$tache['Inventairedetail']['id'].'.produit_id', ['value' => $tache['Inventairedetail']['produit_id'], 'form' => 'DetailForm']); ?>
						<?php echo $this->Form->hidden('Inventairedetail.'.$tache['Inventairedetail']['id'].'.quantite_theorique', ['value' => $tache['Produit']['stockactuel'], 'form' => 'DetailForm']); ?>
						<?php echo $this->Form->input('Inventairedetail.'.$tache['Inventairedetail']['id'].'.quantite_reel', ['class' => 'quantite_reel form-control', 'label' => false, 'required' => true, 'value' => $tache['Inventairedetail']['quantite_reel'], 'form' => 'DetailForm', 'min' => 0, 'style' => 'width:120px;']); ?>
					</td>

					<!-- Ecart -->
					<td nowrap="" class="text-right">
						<?php echo $tache['Inventairedetail']['ecart'] ?></td>					

					<!-- valentree -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['valentree']); ?></td>
					
					<!-- qtentree -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['qtentree']); ?></td>
					
					<!-- valsortie -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['valsortie']); ?></td>

					<!-- qtsortie -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['qtsortie']); ?></td>

					<!-- valvente -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['valvente']); ?></td>

					<!-- qtvente -->
					<td nowrap="" class="text-right"><?php echo h($tache['Inventairedetail']['qtvente']); ?></td>
					
					<?php $ecart = $tache['Depotproduit']['quantite'] - $tache['Inventairedetail']['quantite_reel']; ?>

					<!-- Ecart valorisé (PA) -->
					<td nowrap="" class="text-right"><?php echo number_format($ecart * $tache['Produit']['prixachat'], 2, ',', ' '); ?></td>

					
					<!-- Valeur du stock réel (PA) -->
					<td nowrap="" class="text-right"><?php echo number_format($tache['Inventairedetail']['quantite_reel'] * $tache['Produit']['prixachat'], 2, ',', ' '); ?></td>


					<?php if (isset($inventaire['Inventaire']['statut']) and $inventaire['Inventaire']['statut'] == -1): ?>
					
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
        echo $this->Paginator->counter(['format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'),
        ]); ?></div>
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