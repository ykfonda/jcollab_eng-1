<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Photo</th>
				<th nowrap="">Nom</th>
				<th nowrap="">Prénom</th>
				<th nowrap="">Email</th>
				<th nowrap="">Code Accès</th>
				<th nowrap="">Role</th>
				<th nowrap="">Site</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td class="text-center">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['User']['id']]) ?>">
						<?php if (isset($tache['User']['avatar']) AND file_exists(WWW_ROOT.'/uploads/avatar/user/'.$tache['User']['avatar'])): ?>
							<img style="width: 25px;height: 25px;" class="round" src="<?php echo $this->Html->url('/uploads/avatar/user/'.$tache['User']['avatar']) ?>"/>
						<?php else: ?>		
							<img style="width: 25px;height: 25px;" class="round" src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>"/>
						<?php endif ?>
						</a>
					</td>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['email']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['code_bouchier']); ?></td>
					<td nowrap=""><?php echo h($tache['Role']['libelle']); ?>&nbsp;</td>
					<td nowrap=""><?php echo $this->App->convertToList($tache['Store'],'libelle'); ?>&nbsp;</td>
					<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['date_c']); ?></td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['User']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['User']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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