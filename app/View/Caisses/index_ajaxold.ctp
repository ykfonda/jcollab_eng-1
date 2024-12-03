<?php // get the IP INFO
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ipAddress = gethostbynamel($hostname);
?>

<style>
span.non-autorise {
    z-index: initial;
    color: red !important;
	cursor: not-allowed;
}
</style>

<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Réf</th>
				<th nowrap="">Libellé</th>
				<th nowrap="">Store</th>
				<th nowrap="">Société</th>
				<th nowrap="">Adresse IP</th>
				<th nowrap="">Prefix</th>
				<th nowrap="">Numero</th>
				<th nowrap="">Actif</th>
				<th nowrap="">Url point de vente</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
		<tbody>
			<?php foreach ($taches as $tache): ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Caisse']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Caisse']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Store']['libelle']); ?></td>
					<td nowrap=""><?php echo h($tache['Societe']['designation']); ?></td>
					<td nowrap="" class="Caisse_ip"><?php echo h($tache['Caisse']['ip_adresse']); ?></td>
					<td nowrap=""><?php echo h($tache['Caisse']['prefix']); ?></td>
					<td nowrap=""><?php echo h($tache['Caisse']['numero']); ?></td>
					<td nowrap=""><?php echo $tache['Caisse']['compteur_actif'] == "1" ?  "Oui" : "Non"; ?></td>
					
					<td nowrap="">

					<?php // contrôler si la caisse porte même adresse IP
					$caisse_adresse_ip =  h($tache['Caisse']['ip_adresse']);
					if (in_array($caisse_adresse_ip, $ipAddress)) {
					?>
						<a class="ChooseCaisse" href="<?php echo Router::url(array('controller'=>'Pos', 'action'=>'index',0,$tache['Caisse']['id'])) ?>" style="color : #325ca7"> Choisir </a>
					<?php
					}
					else{
					?>
						<span class="non-autorise">N'est pas autorisé</span>
					<?php
					}
					?>

					</td>


					<td nowrap="" class="actions">
						<?php if ($globalPermission['Permission']['m1']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Caisse']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
						<?php endif ?>
						<?php if ($globalPermission['Permission']['s']): ?>
							<a href="<?php echo $this->Html->url(['action' => 'delete', $tache['Caisse']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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