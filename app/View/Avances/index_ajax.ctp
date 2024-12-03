<br/>
<div class="row">
	<div class="col-lg-4">
	    <div class="dashboard-stat dashboard-stat-v2 purple" href="#">
	        <div class="visual">
	            <i class="fa fa-dollar"></i>
	        </div>
	        <div class="details">
	            <div class="number">
	                <span data-counter="counterup" data-value="<?php echo $chiffre_affaire_valide ?>"><?php echo number_format($chiffre_affaire_valide, 2, ',', ' ') ?> Dh</span>
	            </div>
	            <div class="desc"> Chiffre d'affaire validé  </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-4">
	    <div class="dashboard-stat dashboard-stat-v2 yellow" href="#">
	        <div class="visual">
	            <i class="fa fa-dollar"></i>
	        </div>
	        <div class="details">
	            <div class="number">
	                <span data-counter="counterup" data-value="<?php echo $chiffre_affaire_encours ?>"><?php echo number_format($chiffre_affaire_encours, 2, ',', ' ') ?> Dh</span>
	            </div>
	            <div class="desc"> Chiffre d'affaire en cours  </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-4">
	    <div class="dashboard-stat dashboard-stat-v2 blue" href="#">
	        <div class="visual">
	            <i class="fa fa-dollar"></i>
	        </div>
	        <div class="details">
	            <div class="number">
	                <span data-counter="counterup" data-value="<?php echo $chiffre_affaire_total ?>"><?php echo number_format($chiffre_affaire_total, 2, ',', ' ') ?> Dh</span>
	            </div>
	            <div class="desc"> Chiffre d'affaire total  </div>
	        </div>
	    </div>
	</div>
</div>


<?php $total_montant = 0; ?>
<?php foreach ($avances as $tache): ?>
<?php $total_montant = $total_montant + $tache['Avance']['montant']; ?>
<?php endforeach; ?>

<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive" style="min-height: auto;">
			<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th nowrap="">Réf. avance</th>
						<th nowrap="">Date de délivrance</th>
						<th nowrap="">Date échéance</th>
						<th nowrap="">Bon de livraison</th>
						<th nowrap="">Facture</th>
						<th nowrap="">Client</th>
						<th nowrap="">Mode paiment</th>
						<th nowrap="">Statut</th>
						<th nowrap="">Émetteur/Tél</th>
						<th nowrap="">Montant</th>
						<th class="actions">
							<?php if ( $globalPermission['Permission']['m1'] ): ?>
								<a href="<?php echo $this->Html->url(['action' => 'validateAll']) ?>" class="btnFlagDelete btn btn-success btn-block btn-sm"><i class="fa fa-check-square-o"></i> Valider tous</a>
							<?php endif ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($taches as $tache): ?>
					<tr>
						<td nowrap=""><?php echo h($tache['Avance']['reference']); ?></td>
						<td nowrap=""><?php echo h($tache['Avance']['date']); ?></td>
						<td nowrap=""><?php echo h($tache['Avance']['date_echeance']); ?></td>
						<td nowrap="">
							<?php if ( isset( $tache['Bonlivraison']['id'] ) AND !empty( $tache['Bonlivraison']['id'] ) ): ?>
								<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action' => 'view', $tache['Bonlivraison']['id']]) ?>"><?php echo h($tache['Bonlivraison']['reference']); ?></a>
							<?php endif ?>
						</td>
						<td nowrap="">
							<?php if ( isset( $tache['Facture']['id'] ) AND !empty( $tache['Facture']['id'] ) ): ?>
								<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'factures','action' => 'view', $tache['Facture']['id']]) ?>"><?php echo h($tache['Facture']['reference']); ?></a>
							<?php endif ?>
						</td>
						<td nowrap=""><?php echo ( isset( $tache['Client']['designation'] ) ) ? $tache['Client']['designation'] : ''; ?></td>
						<td nowrap=""><?php echo $this->App->getModePaiment($tache['Avance']['mode']); ?></td>
						<td nowrap="">
							<?php if ( !empty( $tache['Avance']['etat'] ) ): ?>
			                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getStatutAvanceColor($tache['Avance']['etat']); ?>">
			                      <?php echo $this->App->getAvance($tache['Avance']['etat']); ?>
			                    </span>
			                <?php endif ?>
						</td>
						<td nowrap=""><?php echo h($tache['Avance']['emeteur']); ?></td>
						<td nowrap="" class="text-right"><?php echo number_format($tache['Avance']['montant'], 2, ',', ' '); ?></td>
						<td nowrap="" class="actions">
							<?php if ($globalPermission['Permission']['m1'] AND $tache['Avance']['etat'] == -1 ): ?>
								<a href="<?php echo $this->Html->url(['action' => 'changestate', $tache['Avance']['id'],1]) ?>" class="btnFlagDelete btn btn-success btn-block btn-sm"><i class="fa fa-check-square-o"></i> Valider</a>
							<?php endif ?>
							<?php if ($globalPermission['Permission']['m1'] AND $tache['Avance']['etat'] == 1 ): ?>
								<a href="<?php echo $this->Html->url(['action' => 'changestate', $tache['Avance']['id'],-1]) ?>" class="btnFlagDelete btn btn-danger btn-block btn-sm"><i class="fa fa-refresh"></i> Annuler</a>
							<?php endif ?>
						</td>
					</tr>
					<?php endforeach; ?>
					<tr class="total">
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap=""></td>
		                <td nowrap="" class="text-right"><strong><?php echo number_format($total_montant, 2, ',', ' ') ?></strong></td>
		                <td nowrap="" class="actions"></td>
		            </tr>
				</tbody>
			</table>
		</div>
	</div>
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