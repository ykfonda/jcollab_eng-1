<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="" class="actions">Actions</th>
				<th nowrap="">Code à barre</th>
				<th nowrap="">Référence</th>
				<th nowrap="">Libelle</th>
				<th nowrap="">Catégorie</th>
				<th nowrap="">Sous Catégorie</th>
				<th nowrap="">Unité</th>
				<th nowrap="">Prix d'achat</th>
				<th nowrap="">Prix de vente</th>
				<th nowrap="">Actif</th>
				<th nowrap="">Créé par</th>
				<th nowrap="">Date création</th>
				<th nowrap="" class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td class="actions" nowrap="">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Produit']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Produit']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Produit']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
						<?php endif ?>
					</td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['code_barre']); ?></a></td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['reference']); ?></a></td>
					<td nowrap=""><a href="<?php echo $this->Html->url(['action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
					<td nowrap=""><?php echo h($tache['Categorieproduit']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Souscategorieproduit']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Unite']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Produit']['prixachat']); ?></td>
					<td nowrap=""><?php echo h($tache['Produit']['prix_vente']); ?></td>
					<td nowrap=""><?php echo $this->App->OuiNon($tache['Produit']['active']); ?></td>
					<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
					<td nowrap=""><?php echo h($tache['Produit']['date_c']); ?></td>
					<td class="actions" nowrap="">
						<a href="<?php echo $this->Html->url(['action' => 'view', $tache['Produit']['id']]) ?>"><i class="fa fa-eye"></i></a>
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Produit']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Produit']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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