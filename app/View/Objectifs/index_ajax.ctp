<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Réference</th>
				<th nowrap="">Vendeur</th>
				<th nowrap="">Date début</th>
				<th nowrap="">Date fin</th>
				<th nowrap="">Total jrs travail</th>
				<th nowrap="">C.A mensuel</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap="">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Objectif']['id']]) ?>"><?php echo h($tache['Objectif']['reference']); ?></a>
					</td>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?> <?php echo h($tache['User']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Objectif']['dated']); ?></td>
					<td nowrap=""><?php echo h($tache['Objectif']['datef']); ?></td>
					<td nowrap=""><?php echo h($tache['Objectif']['total_jrs_travail']); ?></td>
					<td nowrap=""><?php echo h($tache['Objectif']['c_a_mensuel']); ?></td>
					<td nowrap=""><?php echo h($tache['Objectif']['date_c']); ?></td>
					<td class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Objectif']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Objectif']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Objectif']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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