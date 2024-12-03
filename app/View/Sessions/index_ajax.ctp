<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Nom & Prénom</th>
				<th nowrap="">Username</th>
				<th nowrap="">Active</th>
				<th nowrap="">Date</th>
				<?php if ( in_array($role_id, $admins) ): ?>
				<th class="actions" nowrap="">
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?> <?php echo h($tache['User']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Lastsession']['login']); ?></td>
					<td nowrap="">
						<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getOnlineColor($tache['Lastsession']['logout']); ?>">
							<?php echo $this->App->getOnline($tache['Lastsession']['logout']); ?>
						</span>
					</td>
					<td nowrap=""><?php echo h($tache['Lastsession']['date']); ?></td>
					<?php if ( in_array($role_id, $admins) ): ?>
					<td class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'disconnect', $tache['Lastsession']['id']]) ?>" class="disconnect btn btn-danger btn-sm"><i class="fa fa-sign-out"></i> Se déconnecter</a>
					</td>
					<?php endif ?>
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