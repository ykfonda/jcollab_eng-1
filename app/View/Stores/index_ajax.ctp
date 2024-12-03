<div class="table-responsive" style="min-height: auto;">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th nowrap="">Réf</th>
				<th nowrap="">Nom</th>
				<th nowrap="">Adresse</th>
				<th nowrap="">Société</th>
				<th nowrap="">Type</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Store']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Store']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Store']['adresse']); ?></td>
					<td nowrap=""><?php echo h($tache['Societe']['designation']); ?></td>
					<td nowrap=""><?php echo $this->App->getNature($tache['Store']['type']); ?></td>
					<td nowrap=""><?php echo h($tache['Store']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Store']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s'] ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Store']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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