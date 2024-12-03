<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover " cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Référence</th>
				<th nowrap="">Désignation</th>
				<th nowrap="">Crédit restant</th>
			</tr>
		</thead>
		<tbody>
			<?php $reste_a_payer_total = 0; ?>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => 'clients','action' => 'view', $tache['Client']['id']]) ?>"><?php echo h($tache['Client']['reference']); ?></a></td>
					<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller' => 'clients','action' => 'view', $tache['Client']['id']]) ?>"><?php echo h($tache['Client']['designation']); ?></a></td>
					<?php $reste_a_payer = ( isset( $tache[0]['reste_a_payer'] ) ) ? (float) $tache[0]['reste_a_payer'] : 0; ?>
					<?php $reste_a_payer_total = $reste_a_payer_total + $reste_a_payer; ?>
					<td nowrap="" class="text-right"><?php echo number_format($reste_a_payer, 2, ',', ' '); ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td nowrap=""></td>
				<td nowrap="" class="text-right"><strong>Total des crédit client : </strong></td>
				<td nowrap="" class="text-right"><strong><?php echo number_format($reste_a_payer_total, 2, ',', ' '); ?></strong></td>
			</tr>
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