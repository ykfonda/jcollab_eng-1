<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Client</th>
				<th nowrap="">Vendeur</th>
				<th nowrap="">Date</th>
				<th nowrap="">Etat</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $dossier): ?>
				<tr>
					<td nowrap="">
						<?php if ( $globalPermission['Permission']['m1'] ): ?>
							<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Decharchement']['id']]) ?>"><?php echo h($dossier['Decharchement']['reference']); ?></a>
						<?php else: ?>
							<?php echo h($dossier['Decharchement']['reference']); ?>
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
					<td nowrap=""><?php echo h($dossier['User']['nom']); ?> <?php echo h($dossier['User']['prenom']); ?></td>
					<td nowrap=""><?php echo h($dossier['Decharchement']['date']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $dossier['Decharchement']['etat'] ) ): ?>
							<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatRetourColor($dossier['Decharchement']['etat']); ?>">
								<?php echo $this->App->getEtatRetour($dossier['Decharchement']['etat']); ?>
							</span>
						<?php endif ?>
					</td>
					<td nowrap="" class="actions">
						<?php if ( $globalPermission['Permission']['m1'] ): ?>
							<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Decharchement']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php endif ?>
						<?php if ( $globalPermission['Permission']['s'] AND $dossier['Decharchement']['etat'] == -1 ): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Decharchement']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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