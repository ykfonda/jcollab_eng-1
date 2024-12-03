<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Synchronisations Offline
		</div>
		
	</div>
	<div class="portlet-body">
    <div class="row">
     
      <div class="col-md-12">
      <div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Id</th>
				<th nowrap="">Caisse</th>
				<th nowrap="">Store</th>
				<th nowrap="">Société</th>
				<th nowrap="">Last Sync</th>
				<th nowrap="">Creator</th>
				
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					 
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
      </div>
    </div>
  </div>
</div>
