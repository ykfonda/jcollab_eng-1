<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Objet</th>
				<th nowrap="">Dépot</th>
				<th nowrap="">Statut</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date d'inventaire</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Inventaire']['id']]); ?>"><?php echo h($tache['Inventaire']['reference']); ?></a></td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Inventaire']['id']]); ?>"><?php echo h($tache['Inventaire']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Depot']['libelle']); ?></td>
					<td nowrap="">
						<?php if (!empty($tache['Inventaire']['statut'])): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getStatutInventaireColor($tache['Inventaire']['statut']); ?>">
								<?php echo $this->App->getStatutInventaire($tache['Inventaire']['statut']); ?>
							</span>
						<?php endif; ?>
					</td>
					<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Inventaire']['date']); ?></td>
					<td nowrap=""><?php echo h($tache['Inventaire']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Inventaire']['id']]); ?>"><i class="fa fa-eye"></i></a>
						<?php if ($tache['Inventaire']['statut'] == -1): ?>
							<?php if ($globalPermission['Permission']['m1']): ?>
								<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Inventaire']['id']]); ?>" class="edit"><i class="fa fa-edit"></i></a>
							<?php endif; ?>
							<?php if ($globalPermission['Permission']['s']): ?>
								<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Inventaire']['id']]); ?>" ><i class="fa fa-trash-o"></i></a>
							<?php endif; ?>
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