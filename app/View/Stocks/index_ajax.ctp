<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered table-hover " cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Image</th>
				<th nowrap="">Référence</th>
				<th nowrap="">Produit</th>
				<th nowrap="">Dépot</th>
		        <th nowrap="">Quantité</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td class="text-center">
						<?php if ( !empty( $tache['Produit']['image'] ) AND file_exists( WWW_ROOT."uploads/articles_images/".$tache['Produit']['image'] ) ): ?>
							<img class="img-thumbnail" src="<?php echo $this->Html->url("../uploads/articles_images/".$tache['Produit']['image']) ?>" style="width: 50px;height: 50px;" />
						<?php else: ?>
							<img class="img-thumbnail" src="<?php echo $this->Html->url("../img/no-image.png"); ?>" style="width: 50px;height: 50px;" />
						<?php endif ?>
					</td>
					<td nowrap=""><?php echo h($tache['Produit']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Depot']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Depotproduit']['quantite']); ?></td>
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