<div class="table-responsive" style="min-height: auto;">
	<table class="table table-bordered" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Photo</th>
				<th nowrap="">Nom</th>
				<th nowrap="">Prénom</th>
			</tr>
		</thead>
		<tbody class="users">
			<?php foreach ($taches as $tache): ?>
				<tr style="cursor:pointer;" data-url="<?php echo $this->Html->url(['action'=>'loadmap',$tache['User']['id']]) ?>" class="user-click">
					<td class="text-center">
						<?php if (isset($tache['User']['avatar']) AND file_exists(WWW_ROOT.'/uploads/avatar/user/'.$tache['User']['avatar'])): ?>
							<img style="width: 35px !important;" class="round" src="<?php echo $this->Html->url('/uploads/avatar/user/'.$tache['User']['avatar']) ?>"/>
						<?php else: ?>		
							<img style="width: 35px !important;" class="round" src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>"/>
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['prenom']); ?></td>
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