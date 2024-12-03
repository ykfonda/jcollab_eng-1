


<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Réf</th>
				<th nowrap="">Client</th>
				<th nowrap="">Produit</th>
				<th nowrap="">Categorie</th>
				
				<th nowrap="">Montant</th>
				<th nowrap="">Date limite</th>
				<th nowrap="">Creator</th>
				
				<th class="actions" nowrap="">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href=""><?php echo h($tache['Promotion']['reference']); ?></a></td>
					<td nowrap=""><?php echo isset($tache['Client']['designation']) ? h($tache['Client']['designation']) : 'Tous'; ?></td>
					<td nowrap=""><?php echo isset($tache['Produit']['libelle']) ? h($tache['Produit']['libelle']) : ' '; ?></td>
					<td nowrap=""><?php echo isset($tache['Categorieproduit']['libelle']) ? h($tache['Categorieproduit']['libelle']) : ' '; ?></td>

					<td nowrap=""><?php echo h(number_format($tache['Promotion']['montant'], 2, ',', ' ')); ?></td>
					<td nowrap=""><?php echo h($tache['Promotion']['date_limite']); ?></td>
					<td nowrap=""><?php echo $tache['Creator']['nom'].' '.$tache['Creator']['prenom']; ?></td>
					
					


					<td nowrap="" class="actions">
					
			
					
						<?php if ($globalPermission['Permission']['m1']): ?>
							<?php if (isset($tache['Client']['designation']) and !isset($tache['Categorieproduit']['libelle'])): ?>
							<a href="<?php echo $this->Html->url(['action' => 'editClientProduit', $tache['Promotion']['id']]); ?>" class="edit_promotion"><i class="fa fa-edit"></i></a>
							<?php elseif (isset($tache['Client']['designation']) and isset($tache['Categorieproduit']['libelle'])): ?>
								<a href="<?php echo $this->Html->url(['action' => 'editClientCategorie', $tache['Promotion']['id']]); ?>" class="edit_promotion"><i class="fa fa-edit"></i></a>
								<?php elseif (!isset($tache['Client']['designation']) and !isset($tache['Categorieproduit']['libelle'])): ?>
									<a href="<?php echo $this->Html->url(['action' => 'editGeneraleProduit', $tache['Promotion']['id']]); ?>" class="edit_promotion"><i class="fa fa-edit"></i></a>
									<?php elseif (!isset($tache['Client']['designation']) and isset($tache['Categorieproduit']['libelle'])): ?>
										<a href="<?php echo $this->Html->url(['action' => 'editGeneraleCategorie', $tache['Promotion']['id']]); ?>" class="edit_promotion"><i class="fa fa-edit"></i></a>
										<?php endif; ?>
						<?php endif; ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Promotion']['id']]); ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif; ?>
					</td>
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