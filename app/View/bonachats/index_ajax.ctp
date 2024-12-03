


<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Réf</th>
				<th nowrap="">Date debut</th>
				<th nowrap="">Date fin</th>
				<th nowrap="">Actif</th>
				<th nowrap="">Validité</th>
				<th nowrap="">Date encaissement</th>
				<th nowrap="">Montant</th>
				<th nowrap="">Ref ticket</th>
				<th nowrap="">Numero</th>
				
				<th class="actions" nowrap="">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a href=""><?php echo h($tache['Bonachat']['reference']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Bonachat']['date_debut']); ?></td>
					<td nowrap=""><?php echo h($tache['Bonachat']['date_fin']); ?></td>
					<td nowrap=""><?php echo $tache['Bonachat']['active'] == '1' ? 'Oui' : 'Non'; ?></td>
					<td nowrap="" class="text-center"><?php echo h($tache['Bonachat']['validite']).' Jours'; ?></td>
					<td nowrap=""><?php echo h($tache['Bonachat']['date_encaissement']); ?></td>
					<td nowrap=""><?php echo h(number_format($tache['Bonachat']['montant'], 2, ',', ' ')); ?></td>
					<td nowrap=""><?php echo $tache['Bonachat']['ref_ticket']; ?></td>
					
					<td nowrap="" class="text-center"><?php echo $tache['Bonachat']['numero']; ?></td>
					
					


					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Bonachat']['id']]); ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif; ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Bonachat']['id']]); ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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