
<div style="height : auto" class="table-scrollable">
	<table class="table table-striped table-bordered  table-hover">
		<thead>
			<tr>
				<th nowrap="">Libellé</th>
				<th nowrap="">Date de création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
	<tbody>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $role['Role']['id']]) ?>"><?php echo h($role['Role']['libelle']); ?>&nbsp;</a></td>
		<td nowrap=""><?php echo h($role['Role']['created']); ?>&nbsp;</td>
		
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
	<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
	echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'))); ?></div>
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