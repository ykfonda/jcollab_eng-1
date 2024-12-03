<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Désignation</th>
				<th nowrap="">ICE</th>
				<th nowrap="">Tél</th>
				<th nowrap="">Type</th>
				<th nowrap="">Ville</th>
				<th nowrap="">Responsable</th>
				<th nowrap="">Rating</th>
				<th nowrap="">Classification</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap="">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Client']['id']]) ?>"><?php echo h($tache['Client']['reference']); ?></a>
					</td>
					<td nowrap="">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Client']['id']]) ?>"><?php echo h($tache['Client']['designation']); ?></a>
					</td>
					<td nowrap=""><?php echo h($tache['Client']['ice']); ?></td>
					<td nowrap=""><?php echo h($tache['Client']['telmobile']); ?></td>
					<td nowrap=""><?php echo h($tache['Categorieclient']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Ville']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['User']['nom']); ?> <?php echo h($tache['User']['prenom']); ?></td>
					<td nowrap="">
						<?php if ( !empty( $tache['Client']['rating'] ) ): ?>
							<?php $rating = $this->App->getImportance( $tache['Client']['rating'] ); ?>
							<input type="number" class="rating" value="<?php echo $tache['Client']['rating'] ?>" data-id="<?php echo $tache['Client']['id'] ?>">
						<?php endif ?>
					</td>
					<td nowrap="">
						<?php if ( !empty( $tache['Client']['classification'] ) ): ?>
							<?php echo $this->App->getClassification( $tache['Client']['classification'] ); ?>
						<?php endif ?>
					</td>
					<td nowrap="" class="actions">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Client']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Client']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Client']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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