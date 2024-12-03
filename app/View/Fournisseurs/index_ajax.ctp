<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Désignation</th>
				<th nowrap="">RC</th>
				<th nowrap="">Tél</th>
				<th nowrap="">FAX</th>
				<th nowrap="">Ville</th>
				<th nowrap="">Adresse</th>
				<th nowrap="">Compte comptable</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Fournisseur']['designation']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['registrecommerce']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['telmobile']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['fax']); ?></td>
					<td nowrap=""><?php echo h($tache['Ville']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['adresse']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['compte_comptable']); ?></td>
					<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Fournisseur']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
						<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Fournisseur']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
						<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Fournisseur']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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